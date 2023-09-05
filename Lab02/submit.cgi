#!/usr/bin/perl

#--------------------------------------------------------------------
# IT350 CGI Checker
# by Capt Jesse Kornblum USAF
# modified by Maj Bubba Lennerton USMC
#   This program is a work of the US Government.
#   In accordance with 17 USC 105, works of the US Government are
#   not elligible for copyright protection.
#--------------------------------------------------------------------

# Keep output buffer flushed to update web page as we generate it
$|++;

# No matter what, we need to output a web page of SOME kind!
html_start("IT350 Form Checker CGI");

# Characters allowed in user inputs
# We allow ONLY these characters to be present in inputs.
# everything else gets converted to an underscore.
# See the function "clean" for details
$ok_chars = "_A-z0-9\:\/\.\#\~\$\%\@\ ";

$ENV{'REQUEST_METHOD'} =~ /GET/ && ($query_string = $ENV{'QUERY_STRING'});
$ENV{'REQUEST_METHOD'} =~ /POST/ && ($query_string = <STDIN>);

print "<h1>IT350 Form Checker CGI</h1>\n\n<p>\n";

print "Request method: <b>$ENV{'REQUEST_METHOD'}</b> <br />\n";
print "Query String: $query_string </p>\n\n";

print "<table border=1>\n";
print "  <thead>\n";
print "    <tr>\n";
print "      <th colspan=\"3\">Values Passed to the CGI</th>\n";
print "    </tr><tr>\n";
print "      <th>Duplicate? </th>\n";
print "      <th>Identifier</th>\n";
print "      <th>Value</th>\n";
print "    </tr>";
print "  </thead>\n";
print "  <tbody>\n";

@params = split("\&",$query_string);
foreach (@params)
{
    @v = split("\=",$_);

    $key = clean($v[0]);
    print "    <tr>\n";

    if ($duplicate{$key} eq 1)
    {
      print "     <th><b><font color=\"red\">X</font></b></th>\n";
    } else
    {
      print "     <td> </td>\n";
    }

    print "       <td><tt>" . $key ."</tt></td>\n";
    print "       <td align=\"center\"><tt>";
    print clean($v[1])."</tt>\n";
    print "       </td>\n    </tr>\n";

    $duplicate{$key} = 1;
}

print "  </table>\n";
print "<br /><br /><br /><br />\n";
print "</p>";

print "<hr/>\n\n";
print "<p>Illegal characters passed as CGI input are displayed as underscores.</p>\n\n";


html_stop();
exit 0;


#=====================================================================

sub clean
{
    my $param = shift;
    $param =~ tr/+/ /;
    $param =~ s/%([a-fA-F0-9]{2,2})/chr(hex($1))/eg;
    $param =~ s/<!--(.|\n)*-->//g;

    # Turn all not allowed characters into underscores
    $param =~ s/[^$ok_chars]/_/og;

    return $param;
}

sub html_start
{
  my $title = shift;

  print "Content-type:text/html\n\n";
  print "\<\?xml version=\"1.0\"?>\n";
  print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
  print "<html xmlns = \"http://www.w3.org/1999/xhtml\">\n";

  print "<head>\n";
  print "  <title>$title</title>\n";
  print "</head>\n<body>\n";
}

sub html_stop
{
  print "</body>\n</html>\n";
}

sub html_error
{
    my $text = shift;
    print "<h1>ERROR</h1>\n";
    print "<h2>$text</h2>\n";
    html_stop();
    exit 0;
}
