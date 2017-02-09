<?php 
// $Header: /cvsroot/html2ps/writer.fpdf.class.php,v 1.3 2005/10/24 15:24:27 Konstantin Exp $

class FastPSWriter extends PSWriter {
  function create($compressmode, $pdfcompat) {
    $filename = PSWriter::mk_filename();
    return new FastPSWriter($filename);
  }
  
  function FastPSWriter($file_name) {
    $this->PSWriter($file_name);
    $this->file = fopen($file_name, "wb");
  }

  function get_viewport($media) {
    return new ViewportFastPS($this->file, $media);
  }

  function write($data) { }

  function close() {
    fclose($file_name);
  }

  function release() {
    $this->close();

    $this->output->execute(array('ps','text/postscript'), $this->file_name);
    unlink($this->file_name);
  }
};

?>