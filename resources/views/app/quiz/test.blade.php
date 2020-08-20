<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>fromHTML EX</title>
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <meta name="generator" content="Geany 1.22" />
  <link id="bootstrap-css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
  <script type="text/javascript">
  function PDF1(){
    var doc = new jsPDF();
    doc.setFont("courier");
    var elementHandler = {
      '#ignorePDF': function (element, renderer) {
        return true;
      }
    };
    var source = window.document.getElementsByTagName("body")[0];
    doc.fromHTML(
      source,
      15,
      0.5,
      {
        'width': 180,'elementHandlers': elementHandler
      });
        doc.save('abc.pdf');
    }
    $( document ).ready(function() {
      //console.log( "ready!" );
      $('.button').click(function () {
          PDF1();
          // body...
      })
    });
</script>
  </head>
  
<body>
  <div class="container">
   <b>Identify the Parts You Want to Change</b>
<p>If this is your first time editing a template, try not to get drawn into the idea of tweaking the colors and layout justyet. To do that you have to dig into CSS, the language responsible for page styling. Its a good idea to focus on one thing at a time when youre new to template customization, and HTML is the best place to start.</p>
<p>To get the ball rolling, take a look at your template in Chrome and figure out which written elements and images on the page you need to change. If youd like, you can prepare a list so you can go through and check each item off as you make your edits.</p>
<p>In the case of our CV template we want to change:</p>
    <ul>
    <li>Name</li>
    <li>Profession</li>
    <li>Personal picture</li>
    <li>Social media links</li>
    <li>Contact information</li>
    <li>CVsections: Professional Profile, Work Experience, Technical Skills and Education</li>
    <li>Copyright message</li>
    </ul>
<p>Now we have a list of items to change, we can set about locating their corresponding HTML tags in the code. Lets start with the name.</p>
    <p id="ignorePDF">don't print this to pdf <button class="button">create</button></p>
</div>


</body>
  </html>