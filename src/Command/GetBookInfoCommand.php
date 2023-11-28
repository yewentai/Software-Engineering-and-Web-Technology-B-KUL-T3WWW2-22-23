<?php

namespace App\Command;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[\Symfony\Component\Console\Attribute\AsCommand(name: 'app:get-book-info')]
class GetBookInfoCommand extends Command
{
    protected function configure()
    {
        $this->setDescription('Load book information from Excel file to MySQL database');
    }

    /**
     * @throws Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $host = 'localhost';
        $database = 'a22web41';
        $username = 'root';
        $password = '20lkbYzt';

        $excelFile = __DIR__.'/../Command/bookinfo.xlsx';

        $spreadsheet = IOFactory::load($excelFile);
        $worksheet = $spreadsheet->getSheetByName('Sheet1');

        $conn = DriverManager::getConnection([
            'url' => "mysql:host=$host;dbname=$database",
            'user' => $username,
            'password' => $password,
        ]);

        $conn->beginTransaction();

        foreach ($worksheet->getRowIterator($startRow = 2, $endRow = null) as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);

            $isbn = $cellIterator->current()->getValue();

            $conn->insert('book', [
                'isbn' => $isbn,
            ]);
        }

        $conn->commit();

        $output->writeln('Data loaded successfully into MySQL database.');

        return Command::SUCCESS;
    }
}
