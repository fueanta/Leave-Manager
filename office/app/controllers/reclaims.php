<?php
  class reclaims extends controller {

    public function __construct() {
      global $active;
      $active = "reclaims";

      $this->reclaimModel = $this->model('reclaim');
      $this->applicationModel = $this->model('application');
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

    public function process() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $msg = '';
        if (isset($_POST['accepted'])) {
          $msg = 'Accepted';

          // update or delete application record
          if ($_POST['application_days'] == $_POST['reclaim_days']) {
            // delete application
            $this->applicationModel->reclaim_application( $_POST['application_id'] );
          } else {
            // update application days
            $updated_from_date = '';
            $updated_to_date = '';

            if ($_POST['reclaim_from'] == $_POST['application_from']) {
              // cut days from beginning
              $updated_from_date = date('Y-m-d', strtotime($_POST['reclaim_to'] . ' +1 day'));
              $updated_to_date = $_POST['application_to'];
            }
            elseif ($_POST['reclaim_to'] == $_POST['application_to']) {
              // cut days from end
              $updated_from_date = $_POST['application_from'];
              $updated_to_date = date('Y-m-d', strtotime($_POST['reclaim_from'] . ' -1 day'));
            }
            else {
              die('Unauthorized action: Reclaiming days from unauthorized point.');
            }

            $this->applicationModel->update_application_days($_POST['application_id'], $updated_from_date, $updated_to_date);
          }

          // send mail to the applicant
          $application = $this->applicationModel->get_application_details( $_POST['application_id'] );
          $employee_id = $application->employee_id;
          $employee_email = $this->userModel->get_email_by_id( $employee_id );
          $supervisor_id = $application->{'Supervisor Id'};
          $supervisor_name = $this->userModel->get_name_by_id( $supervisor_id );
          $link = URLROOT . '/index.php?url=applications/details/' . $_POST['application_id'];
          $sent = send_mail(
            $employee_email,
            'Reclaim Application Accepted.',
            prepare_html_message('Your reclaim application has been accepted by your supervisor, ' . $supervisor_name . '.', $link)
          );

        }
        elseif (isset($_POST['declined'])) {
          $msg = 'Declined';

          // send mail to the applicant
          $application = $this->applicationModel->get_application_details( $_POST['application_id'] );
          $employee_id = $application->employee_id;
          $employee_email = $this->userModel->get_email_by_id( $employee_id );
          $supervisor_id = $application->{'Supervisor Id'};
          $supervisor_name = $this->userModel->get_name_by_id( $supervisor_id );
          $link = URLROOT . '/index.php?url=applications/details/' . $_POST['application_id'];
          $sent = send_mail(
            $employee_email,
            'Reclaim Application Declined.',
            prepare_html_message('Your reclaim application has been declined by your supervisor, ' . $supervisor_name . '.', $link)
          );

        }

        $processed = $this->reclaimModel->process_reclaim($_POST['reclaim_id'], $msg);

        if( $processed ) {
          flash('processed_reclaim', 'Reclaim application has been ' . strtolower($msg) . '.');
          redirect('reclaims/');
        } else {
          die( 'Reclaim application could not be processed.' );
        }
      }
    }

    public function details($id) {
      if ( ! isLoggedIn() ) {
        $_SESSION['redirect'] = catchURL();
        flash('login_required', 'You need to log in first.. 😒', 'alert alert-warning');
        redirect('users/login');
      }

      $reclaim = $this->reclaimModel->get_reclaim_details($id);

      if ( ! $reclaim ) {
        echo '<h2>Oops! Looks like such "Reclaim Application" does not exist or has been deleted by the applicant.</h2>';
        die();
      }

      $application = $this->applicationModel->get_application_details($reclaim->application_id);

      if ( $_SESSION['user_id'] != $application->employee_id && $_SESSION['user_id'] != $application->{'Supervisor Id'} && getUserType() !== 'HR' ) {
        flash('unauthorized_application_access', 'You do not have access to this application.. 😑', 'alert alert-danger');
        redirect('reclaims');
      }

      $leave_status = $this->applicationModel->get_leave_status($application->employee_id);

      $data_array = [
        // list of data to be sent
        "reclaim" => $reclaim,
        "application" => $application,
        "leaveStatus" => $leave_status
      ];

      if ( isset( $_SESSION['redirect'] ) ) {
        unset( $_SESSION['redirect'] );
      }

      $this->view_path(__FUNCTION__, $data_array);
    }

    public function delete_reclaim() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $deleted = $this->reclaimModel->delete_reclaim( $_POST['reclaim_id'] );
        if( $deleted ) {
          flash('deleted_reclaim', 'Your reclaim application has been deleted.. 😅', 'alert alert-danger');
          redirect('reclaims/');
        }
      }
    }

    public function modify_reclaim() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $from_date = $_POST['fromdate'];
        $to_date = $_POST['todate'];
        $days = $_POST['days'] - 1;

        if ($_POST['from'] == 'beginning') {
          $to_date = date('Y-m-d', strtotime($from_date. ' + ' . $days . ' days'));
        } elseif ($_POST['from'] == 'end') {
          $from_date = date('Y-m-d', strtotime($to_date. ' - ' . $days . ' days'));
        }

        $data_array = [
          // list of data to be sent
          "application_id" => $_POST['application_id'],
          "supervisor_id" => $_POST['supervisor_id'],
          "from_date" => $from_date,
          "to_date" => $to_date,
          "reclaim_id" => $_POST['reclaim_id']
        ];

        $updated = $this->reclaimModel->put_reclaim($data_array);

        if( $updated ) {
          flash('updated_reclaim', 'Your reclaim application has been updated.. 😅');
          redirect('reclaims/');
        }
        else {
          die( 'Reclaim Application could not be submitted.' );
        }
      }
    }

    public function submit_reclaim() {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $from_date = $_POST['fromdate'];
        $to_date = $_POST['todate'];
        $days = $_POST['days'] - 1;

        if ($_POST['from'] == 'beginning') {
          $to_date = date('Y-m-d', strtotime($from_date. ' + ' . $days . ' days'));
        } elseif ($_POST['from'] == 'end') {
          $from_date = date('Y-m-d', strtotime($to_date. ' - ' . $days . ' days'));
        }

        $data_array = [
          // list of data to be sent
          "application_id" => $_POST['application_id'],
          "supervisor_id" => $_POST['supervisor_id'],
          "from_date" => $from_date,
          "to_date" => $to_date
        ];

        $posted = $this->reclaimModel->post_reclaim($data_array);

        if( $posted ) {
          flash('posted_reclaim', 'Reclaim application has been sent to your supervisor.. 🥱');
  
          // send mail to supervisor
          $supervisor_email = $this->userModel->get_email_by_id( $_POST['supervisor_id'] );
          $user_name = $_SESSION['user_name'];
          $link = URLROOT . '/index.php?url=reclaims/details/' . $_SESSION['lastInsertId'];
          $sent = send_mail(
            $supervisor_email,
            'Request for Reclaiming Days.',
            prepare_html_message($user_name . ' has reclaimed days from a leave.', $link)
          );          
  
          redirect('reclaims/');
        }
        else {
          die( 'Reclaim Application could not be submitted.' );
        }
      }
    }

    // this function dynamically loads the view resource
    private function view_path($method_name, $data_array = null) {
      $this->view(__CLASS__ . '/' . $method_name, $data_array);
    }

  }