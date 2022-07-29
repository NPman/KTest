<?php
require_once '../include/inc.php';

$guestBookRepository = new \Kelnik\Repository\GuestBookRepository();

$result = [];

try {
    $guestBook = new \Kelnik\Entity\GuestBook(
        null,
        new \DateTime(),
        $_POST['name'],
        $_POST['email'],
        $_POST['body']
    );

    $result = $guestBookRepository->save($guestBook);

    if (!$result->isSuccess()) {
        throw new Exception('Error: message not added');
    }
} catch (\Exception $e) {
    header('HTTP/1.1 422 Unprocessable Entity');
    $result['error'] = $e->getMessage();
}

header('Content-Type: application/json; charset=utf-8');
echo \json_encode($result,JSON_THROW_ON_ERROR);

