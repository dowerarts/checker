<?php
    if (! function_exists('imap_open')) {
        echo "IMAP is not configured.";
        exit();
    } else {
$connection = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'gixmotovlog1908@gmail.com', 'Alfarz123') or die('Cannot connect to Gmail: ' . imap_last_error());
$emailData = imap_search($connection, 'SUBJECT "Instagram code"');
if (! empty($emailData)) {
foreach ($emailData as $emailIdent) {
                
    $overview = imap_fetch_overview($connection, $emailIdent, 0);
    $message = imap_fetchbody($connection, $emailIdent, '1.1');
    $messageExcerpt = substr($message, 0, 150);
    $partialMessage = trim(quoted_printable_decode($messageExcerpt)); 
    $date = date("d F, Y", strtotime($overview[0]->date));

    $hasil = $overview[0]->subject;
    preg_match('#(.*) is your#', $hasil, $code);
    $code = $code[1];
}
}
imap_close($connection);
}

