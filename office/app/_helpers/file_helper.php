<?php

$fileSizeLimit = 2097152; // 2 Megabytes

$allowedExts = array( 'jpg', 'jpeg', 'png', 'pdf', 'doc' );

function upload_files( $files, $document_type, $document_ref ) {
  global $fileSizeLimit, $allowedExts;

  $fileNames = $files[ 'name' ];
  $fileTmpNames = $files[ 'tmp_name' ];
  $fileSizes = $files[ 'size' ];
  $fileErrors = $files[ 'error' ];
  $fileTypes = $files[ 'type' ];

  $uploadedFiles= [];

  for( $i = 0; $i < count( $fileNames ); $i++ ) {
    $fileNameParts = explode( '.', $fileNames[ $i ] );
    $fileExt = strtolower( end( $fileNameParts ) );

    if( in_array( $fileExt, $allowedExts ) ) {
      // Type is OK
      if ( $fileSizes[$i] <= $fileSizeLimit ) {
        // File Size is fine
        if ( $fileErrors[$i] === 0 ) {
          // No common errors
          $fileNameNew = uniqid( $document_type . '-' . $document_ref, true ) . '.' . $fileExt;
          $fileDestination = APPROOT . '//_uploads/' . $fileNameNew;
          move_uploaded_file( $fileTmpNames[$i], $fileDestination );
          array_push($uploadedFiles, $fileNameNew);
        }
      }
    }
  }

  return $uploadedFiles;
}

function delete_file( $file_name ) {
  $file = APPROOT . '//_uploads/' . $file_name;
  if ( ! unlink( $file ) ) {
    die( 'A document could not be deleted!' );
  }
}