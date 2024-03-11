<?php
// Initialize an empty array to store the text
$textArray = [];

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // If file is selected
    if(!empty($_FILES["pdf_file"]["name"])) {
        // File upload path
        $fileName = basename($_FILES["pdf_file"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('pdf');
        if(in_array($fileType, $allowTypes)) {
            // Include autoloader file
            include 'vendor/autoload.php';

            // Initialize and load PDF Parser library
            $parser = new \Smalot\PdfParser\Parser();

            // Source PDF file to extract text
            $file = $_FILES["pdf_file"]["tmp_name"];

            // Parse pdf file using Parser library
            $pdf = $parser->parseFile($file);

            // Extract text from PDF
            $text = $pdf->getText();

            // Split text into an array by line breaks
            $textArray = str_word_count($text, 1);
        } else {
            $statusMsg = '<p>only PDF file </p>';
        }
    } else {
        $statusMsg = '<p>Please select a PDF file </p>';
    }
}
?>

<!-- Output the text array to JavaScript -->
<script>
    // Assign PHP text array to JavaScript text array
    var textArray = <?php echo json_encode($textArray); ?>;
    console.log(textArray.length);
    console.log(textArray[1]); // Output the JavaScript array length to console
</script>
