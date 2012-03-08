<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
function compress()
{
	$CI =& get_instance();
	$buffer = $CI->output->get_output();
 
	/*
	$search = '/(?>[^\S ]\s*|\s{2,})/'; // everything
	$search = '#(?>[^\S ]\s*|\s{2,})(?=(?:(?:[^<]++|<(?!/?pre\b))*+)(?:<pre>|\z))#'; // everything minus <pre>
	*/
	// everything minus textarea and pre
	/*$search = '#(?ix)(?>[^\S ]\s*|\s{2,})(?=(?:(?:[^<]++|<(?!/?(?:textarea|pre)\b))*+)(?:<(?>textarea|pre)\b|\z))#';
	$replace = ' ';
 	
 	$buffer = preg_replace($search, $replace, $buffer);*/

 	$buffer = $buffer;
 	//$buffer = process_data_jmr1($buffer);

	$CI->output->set_output($buffer);
	$CI->output->_display();
}

//stackoverflow.com/questions/5312349/minifying-final-html-output-using-regular-expressions-with-codeigniter
// Set PCRE recursion limit to sane value = STACKSIZE / 500
// ini_set("pcre.recursion_limit", "524"); // 256KB stack. Win32 Apache
ini_set("pcre.recursion_limit", "16777");  // 8MB stack. *nix
function process_data_jmr1($text) // 
{
    $re = '%# Collapse whitespace everywhere but in blacklisted elements.
        (?>             # Match all whitespans other than single space.
          [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
        | \s{2,}        # or two or more consecutive-any-whitespace.
        ) # Note: The remaining regex consumes no text at all...
        (?=             # Ensure we are not in a blacklist tag.
          [^<]*+        # Either zero or more non-"<" {normal*}
          (?:           # Begin {(special normal*)*} construct
            <           # or a < starting a non-blacklist tag.
            (?!/?(?:textarea|pre|script)\b)
            [^<]*+      # more non-"<" {normal*}
          )*+           # Finish "unrolling-the-loop"
          (?:           # Begin alternation group.
            <           # Either a blacklist start tag.
            (?>textarea|pre|script)\b
          | \z          # or end of file.
          )             # End alternation group.
        )  # If we made it here, we are not in a blacklist tag.
        %Six';
    $text = preg_replace($re, " ", $text);
    if ($text === null) exit("PCRE Error! File too big.\n");
    return $text;
}
 
/* End of file compress.php */
/* Location: ./system/application/hools/compress.php */