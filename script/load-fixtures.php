<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap.php';

use Faker\Factory;
use Faker\ORM\Doctrine\Populator;
use Guestbook\Entity\GuestbookRecord;
use Guestbook\Entity\User;
use Guestbook\Entity\UserAgent;

/**
 * Command-line arguments processing
 */
$params = array(
    '' => 'help',
    'n::' => 'number:',
    'f::' => 'force-load:',
    'D::' => 'drop-table-data::',
);

// Default values
$number = 50;
$forceLoad = false;
$dropExistedData = false;
$errors = array();

$options = getopt(implode('', array_keys($params)), $params);

if (isset($options['number']) || isset($options['n'])) {
    $number = intval(isset($options['number']) ? $options['number'] : $options['n']);
    if (empty($number) || $number > 1000) {
        die("Invalid argument, aborting." . PHP_EOL);
    }
}

if (isset($options['force-load']) || isset($options['f'])) {
    $forceLoad = true;
}

if (isset($options['drop-table-data']) || isset($options['D'])) {
    $dropExistedData = true;
}

if (isset($options['help']) || count($errors)) {
    $help = "
usage: php load-fixtures.php [--help] [-n|--number NUMBER] [-f|--force-load] [-D|--drop-table-data]

Options:
            --help              Show this message.
        -n  --number            Number of generated fake records to load. Default 50. Maximum 1000.
        -f  --force-load        Force load fake data in non-empty database.
        -D  --drop-table-data   If set, all existing data in all tables will be purged before loading fake data.
Example:
        php save-data.php --number 10 --force-load
";
    if ($errors) {
        $help .= 'Errors:' . PHP_EOL . implode("\n", $errors) . PHP_EOL;
    }
    die($help);
}

$guestbookRecordRepository = $entityManager->getRepository(GuestbookRecord::class);
$userAgentRepository = $entityManager->getRepository(UserAgent::class);
$userRepository = $entityManager->getRepository(User::class);

/**
 * Remove all the data from DB before insert
 */
if (true === $dropExistedData) {
    $tables = array();
    $tables[] = $guestbookRecordRepository->findAll();
    $tables[] = $userAgentRepository->findAll();
    $tables[] = $userRepository->findAll();

    foreach ($tables as $table) {
        foreach ($table as $row) {
            $entityManager->remove($row);
        }
    }
    $entityManager->flush();
}

$guestbookRecordCount = $guestbookRecordRepository->count([]);

if ($guestbookRecordCount !== 0 and true !== $forceLoad) {
    die("Can't load fake data in non-empty database. Use -f or -D options. Type --help for more info." . PHP_EOL);
} else {
    $generator = Factory::create();
    $populator = new Populator($generator, $entityManager);

    $populator->addEntity(User::class, $number, array(
        'userName' => function () use ($generator) {
            return $generator->name('male' | 'female');
        },
        'userIp' => function () use ($generator) {
            return $generator->ipv4();
        }));
    $populator->addEntity(UserAgent::class, $number, array(
        'userAgent' => function () use ($generator) {
            return $generator->userAgent();
        }));
    $populator->addEntity(GuestbookRecord::class, $number);

    $insertedPKs = $populator->execute();

    echo sprintf("Inserted %d generated records successfully." . PHP_EOL, $number);
}