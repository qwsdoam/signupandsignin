class Mail{
   
    public $to;
   
    public $from;
    
    public $subject;
  
    public $text_content;
 
    public $html_content;
    
    private $body;
   
    private $attachments;
    
    private $headers;
   
    private $header_string;
   
    private $boundary_hash;
   
    private $sent;
    
    public function __construct($to, $from, $subject, $text_content = "", $html_content = ""){
      $this->to            = $to;
      $this->from          = $from;
      $this->subject       = $this->convert_utf8($subject);
      $this->text_content  = $text_content;
      $this->html_content  = $html_content;
      $this->body          = "";
      $this->attachments   = array();
	  $this->base64_attachments   = array();
      $this->headers       = array();
      $this->boundary_hash = md5(date('r', time()));
    }
    
    public function send(){
      $this->prepare_headers();      
      $this->prepare_body();
      if(!empty($this->attachments)){
        $this->prepare_attachments();  
      }
      if(!empty($this->base64_attachments)){
        $this->prepare_base64_attachments();  
      }
      $this->sent = mail($this->to, $this->subject, $this->body, $this->header_string);
      return $this->sent;
    }
   
    public function add_header($header){
      $this->headers[] = $header;
    }
   
    public function add_attachment($file){
      $this->attachments[] = $file;
    }
    public function add_base64_attachment($name,$data){
      $this->base64_attachments[] = array('name'=>$name, 'data'=>$data);
    }
    private function prepare_body(){
      $this->body .= "--PHP-mixed-{$this->boundary_hash}\n";
      $this->body .= "Content-Type: multipart/alternative; boundary=\"PHP-alt-{$this->boundary_hash}\"\n\n";
      if(!empty($this->text_content)) $this->prepare_text();
      if(!empty($this->html_content)) $this->prepare_html();
      $this->body .= "--PHP-alt-{$this->boundary_hash}--\n\n";
    }
    private function prepare_headers(){
      $this->set_default_headers();
      $this->header_string = implode(PHP_EOL, $this->headers).PHP_EOL;
    }
    private function set_default_headers(){
      $this->headers[] = 'MIME-Version: 1.0';
      $this->headers[] = "From: {$this->from}";
      $this->headers[] = "Content-type: multipart/mixed; boundary=\"PHP-mixed-{$this->boundary_hash}\"";
    }
    private function prepare_base64_attachments(){
      foreach($this->base64_attachments as $attachment){
        $this->body .= "--PHP-mixed-{$this->boundary_hash}\n";
        $this->body .= "Content-Type: application/octet-stream; name=\"{$attachment['name']}\"\n";
        $this->body .= "Content-Transfer-Encoding: base64\n";
        $this->body .= "Content-Disposition: attachment\n\n";
        $this->body .= chunk_split($attachment['data']);
        $this->body .= "\n\n";
      }
      $this->body .= "--PHP-mixed-{$this->boundary_hash}--\n\n";
    }
	
    private function prepare_attachments(){
      foreach($this->attachments as $attachment){
        $file_name  = basename($attachment);
        $file_name  = $this->convert_utf8($file_name);
        $this->body .= "--PHP-mixed-{$this->boundary_hash}\n";
        $this->body .= "Content-Type: application/octet-stream; name=\"{$file_name}\"\n";
        $this->body .= "Content-Transfer-Encoding: base64\n";
        $this->body .= "Content-Disposition: attachment\n\n";
        $this->body .= chunk_split(base64_encode(file_get_contents($attachment)));
        $this->body .= "\n\n";
      }
      $this->body .= "--PHP-mixed-{$this->boundary_hash}--\n\n";
    }
	
    private function prepare_text(){
      $this->body .= "--PHP-alt-{$this->boundary_hash}\n";
      $this->body .= "Content-Type: text/plain; charset=\"utf-8\"\n";
      $this->body .= "Content-Transfer-Encoding: 8bit\n\n";
      $this->body .= $this->text_content."\n\n";
    }
    private function prepare_html(){
      $this->body .= "--PHP-alt-{$this->boundary_hash}\n";
      $this->body .= "Content-Type: text/html; charset=\"utf-8\"\n";
      $this->body .= "Content-Transfer-Encoding: 8bit\n\n";
      $this->body .= $this->html_content."\n\n";
    }
    private function convert_utf8($subject){
        return '=?UTF-8?B?'.base64_encode($subject).'?=';
    }
  }
