<?php
  class applications extends controller {

    public function __construct() {
      global $active;
      $active = "applications";

      $this->applicationModel = $this->model('application');
      $this->reclaimModel = $this->model('reclaim');
      $this->userModel = $this->model('user');
    }

    public function index() {
      if (!isLoggedIn()) {
        flash('login_required', 'You need to log in first.. 😒', 'alert alert-warning');
        redirect('users/login');
      }

      if ( isset($_SESSION['lastInsertId']) ) {
        unset( $_SESSION['lastInsertId'] );
      }

      $data_array = [
        // list of data to be sent
        'id' => $_SESSION['user_id']
      ];

      $this->view_path(__FUNCTION__, $data_array);
    }

    public function application_form() {
      if (!isLoggedIn()) {
        flash('login_required', 'You need to log in first.. 😒', 'alert alert-warning');
        redirect('users/login');
      }

      $leave_status = $this->applicationModel->get_leave_status($_SESSION['user_id']);

      if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $data_array = [
          // list of data to be sent
          "id" => '',
          "reason" => '',
          "leave" => '',
          "delegate" => '',
          "from" => date("Y-m-d"),
          "to" => date("Y-m-d"),

          "leaveStatus" => $leave_status,
          "leaves" => $this->applicationModel->get_leave_dropdown_items(),
          "delegates" => $this->applicationModel->get_delegate_dropdown_items($_SESSION['user_id']),
          "documents" => [],
          "submit_type" => "post"
        ];
      }
      else {
        if (isset($_POST['modify'])) {
          $application = $this->applicationModel->get_application_form_by_id($_POST['application_id']);
          $documents = $this->applicationModel->get_application_documents( $_POST['application_id'] );
          $data_array = [
            // list of data to be sent
            "id" => $_POST['application_id'],
            "reason" => $application->reason,
            "leave" => $application->leaveType,
            "delegate" => $application->delegate,
            "from" => $application->fromDate,
            "to" => $application->toDate,
  
            "leaveStatus" => $leave_status,
            "leaves" => $this->applicationModel->get_leave_dropdown_items(),
            "delegates" => $this->applicationModel->get_delegate_dropdown_items($_SESSION['user_id']),
            "documents" => $documents,
            "submit_type" => "put"
          ];        
        }
      }

      $this->view_path(__FUNCTION__, $data_array);
    }

    public function delete_application_form() {
      // delete unprocessed application
      if( isset( $_POST['application_id'] ) ) {
          $deleted = $this->applicationModel->delete_application($_POST['application_id']);
        if( $deleted ) {
          flash('deleted_application', 'Your application has been deleted.. 😅', 'alert alert-danger');

          // deleting application documents as well ( if available )
          $this->delete_document_files( $_POST['application_id'] );

          redirect('applications/');
        } else {
          die( 'Your application could not be deleted.' );
        }
      }
    }

    public function post_application_form() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $data_array = [
          // list of data to be sent
          "id" => $_POST['id'],
          "employee_id" => $_SESSION['user_id'],
          "leave_id" => $_POST['leave'],
          "from_date" => $_POST['fromdate'],
          "to_date" => $_POST['todate'],
          "reason" => $_POST['reason'],
          "delegate_id" => $_POST['delegate'],
          "supervisor_id" => $this->userModel->get_supervisor_id_by_user_id( $_SESSION['user_id'] )
        ];

        $posted = false; $updated = false;
        if ($_POST['submit_type'] == "post") {
          // posting leave application
          $posted = $this->applicationModel->post_application($data_array);
        }
        elseif ($_POST['submit_type'] == "put") {
          // updating leave application
          $updated = $this->applicationModel->put_application($data_array);
        }

        if( $posted ) {
          flash('posted_application', 'Application has been sent to be verified by your delegate.. 🥱');

          // save attachments if uploaded
          $files = $_FILES[ 'files' ];
          $fileNames = upload_files( $files, 'leave_application', $_SESSION['lastInsertId'] );
          if ( count( $fileNames ) > 0 ) {
            $uploaded = $this->applicationModel->map_application_documents( $fileNames, $_SESSION['lastInsertId'] );
          }

          // send mail to delegate
          $delegate_email = $this->userModel->get_email_by_id( $_POST['delegate'] );
          $user_name = $_SESSION['user_name'];
          $link = URLROOT . '/index.php?url=applications/details/' . $_SESSION['lastInsertId'];
          $sent = send_mail(
            $delegate_email,
            'Request for Delegation.',
            prepare_html_message('You have been requested for delegation by ' . $user_name . '.', $link)
          );
          
          redirect('applications/');
        } elseif( $updated ) {
          flash('updated_application', 'Your application has been updated.. 😅');

          // save attachments if updated
          if ( strlen( $_FILES[ 'files' ][ 'name' ][ 0 ] ) > 0 ) {
            // first deleting old documents
            $this->delete_document_files( $_POST['id'] );

            // then uploading new records
            $files = $_FILES[ 'files' ];
            $fileNames = upload_files( $files, 'leave_application', $_POST['id'] );
            if ( count( $fileNames ) > 0 ) {
              $uploaded = $this->applicationModel->map_application_documents( $fileNames, $_POST['id'] );
            }
          }
          else {
            // if documents are not necessary, delete em
            $from = $_POST['fromdate'];
            $to = $_POST['todate'];
            $date_diff = strtotime($to) - strtotime($from);
            $date_diff = round($date_diff / (60 * 60 * 24)) + 1;

            if($date_diff <= $_POST['document_required_after']) {
              $this->delete_document_files( $_POST['id'] );
            }
          }

          redirect('applications/');
        } else {
          die( 'Leave Application could not be submitted.' );
        }
      }
    }

    public function delete_document_files($application_id) {
      // deleting previous records first
      $documents = $this->applicationModel->get_application_documents($application_id);
      foreach( $documents as $document ) {
        delete_file( $document->document_name );
      }
      $documents_deleted = $this->applicationModel->unmap_application_documents($application_id);
    }

    public function details($id) {
      if ( ! isLoggedIn() ) {
        $_SESSION['redirect'] = catchURL();
        flash('login_required', 'You need to log in first.. 😒', 'alert alert-warning');
        redirect('users/login');
      }

      $application = $this->applicationModel->get_application_details($id);

      if ( ! $application ) {
        echo '<h2>Oops! Looks like such "Leave Application" does not exist or has been deleted by the applicant.</h2>';
        die();
      }

      if ( $_SESSION['user_id'] != $application->employee_id && $_SESSION['user_id'] != $application->{'Delegate Id'} && $_SESSION['user_id'] != $application->{'Supervisor Id'} && getUserType() !== 'HR' ) {
        flash('unauthorized_application_access', 'You do not have access to this application.. 😑', 'alert alert-danger');
        redirect('applications');
      }

      $documents = $this->applicationModel->get_application_documents( $id );
      $reclaim = $this->reclaimModel->get_pending_reclaim_by_application_id($application->id);
      $leave_status = $this->applicationModel->get_leave_status($application->employee_id);

      $data_array = [
        // list of data to be sent
        "application" => $application,
        "documents" => $documents,
        "reclaim" => $reclaim,
        "leaveStatus" => $leave_status
      ];

      if ( isset( $_SESSION['redirect'] ) ) {
        unset( $_SESSION['redirect'] );
      }

      $this->view_path(__FUNCTION__, $data_array);
    }

    public function process() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $msg = '';
        $color = 'alert alert-success';
        if (isset($_POST['accepted'])) {
          $msg = 'Accepted';
          $is_declined = 'Not Declined';

          // send mail to the applicant
          $application = $this->applicationModel->get_application_details( $_POST['application_id'] );
          $employee_id = $application->employee_id;
          $employee_email = $this->userModel->get_email_by_id( $employee_id );
          $supervisor_id = $application->{'Supervisor Id'};
          $supervisor_name = $this->userModel->get_name_by_id( $supervisor_id );
          $link = URLROOT . '/index.php?url=applications/details/' . $_POST['application_id'];
          $sent = send_mail(
            $employee_email,
            'Leave Application Accepted.',
            prepare_html_message('Your leave application has been accepted by your supervisor, ' . $supervisor_name . '.', $link)
          );

        }
        elseif (isset($_POST['delegated'])) {
          $msg = 'Delegated';
          $is_declined = 'Not Declined';

          // send mail to supervisor
          $application = $this->applicationModel->get_application_details( $_POST['application_id'] );
          // $supervisor_id = $this->applicationModel->get_supervisor_id_from_application( $_POST['application_id'] );
          $supervisor_id = $application->{'Supervisor Id'};
          $supervisor_email = $this->userModel->get_email_by_id( $supervisor_id );
          $employee_id = $application->employee_id;
          $employee_name = $this->userModel->get_name_by_id( $employee_id );
          $link = URLROOT . '/index.php?url=applications/details/' . $_POST['application_id'];
          $sent = send_mail(
            $supervisor_email,
            'Request for a leave.',
            prepare_html_message($employee_name . ' has requested for a leave.', $link)
          );

        }
        elseif (isset($_POST['declinedBySupervisor'])) {
          $msg = 'Declined';
          $color = 'alert alert-warning';
          $is_declined = 'Supervisor';

          // send mail to the applicant
          $application = $this->applicationModel->get_application_details( $_POST['application_id'] );
          $employee_id = $application->employee_id;
          $employee_email = $this->userModel->get_email_by_id( $employee_id );
          $supervisor_id = $application->{'Supervisor Id'};
          $supervisor_name = $this->userModel->get_name_by_id( $supervisor_id );
          $link = URLROOT . '/index.php?url=applications/details/' . $_POST['application_id'];
          $sent = send_mail(
            $employee_email,
            'Leave Application Declined.',
            prepare_html_message('Your leave application has been declined by your supervisor, ' . $supervisor_name . '.', $link)
          );

        }
        elseif (isset($_POST['declinedByDelegate'])) {
          $msg = 'Declined';
          $color = 'alert alert-warning';
          $is_declined = 'Delegate';

          // send mail to the applicant
          $application = $this->applicationModel->get_application_details( $_POST['application_id'] );
          $employee_id = $application->employee_id;
          $employee_email = $this->userModel->get_email_by_id( $employee_id );
          $delegate_id = $application->{'Delegate Id'};
          $delegate_name = $this->userModel->get_name_by_id( $delegate_id );
          $link = URLROOT . '/index.php?url=applications/details/' . $_POST['application_id'];
          $sent = send_mail(
            $employee_email,
            'Delegation Request Declined.',
            prepare_html_message('Delegation request has been declined by ' . $delegate_name . '.', $link)
          );

        }
        $updated = $this->applicationModel->process_application($_POST['application_id'], $msg, $is_declined);

        if( $updated ) {
          flash('processed_application', 'Application has been ' . strtolower($msg) . '.', $color);
          redirect('applications/');
        } else {
          die( 'Application could not be processed.' );
        }
      }
    }

    // this function dynamically loads the view resource
    private function view_path($method_name, $data_array = null) {
      $this->view(__CLASS__ . '/' . $method_name, $data_array);
    }

  }