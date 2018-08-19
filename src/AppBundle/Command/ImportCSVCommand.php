<?php

namespace AppBundle\Command;

use AppBundle\Domain\Stock\Model\Stock;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Debug\Exception\ContextErrorException;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ImportCSVCommand extends ContainerAwareCommand
{
    const STOCK_FILENAME = 'stock.csv';

    protected function configure()
    {
        $this
            ->setName('app:import_from_csv')
            ->setDescription('Import csv-file to database.')
            ->addOption('test', 't', InputOption::VALUE_NONE, 'Without insert to database.');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $totalRows = $insertRows = $errorRows = 0;

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $stockRepository = $this->getContainer()->get('app.domain_stock_repository.stock_repository');

        $isTest = $input->getOption('test');

        $io = new SymfonyStyle($input, $output);

        try {
            $stocks = $this->getStocks();
            $totalRows = count($stocks);

            $io->block("Stocks successfully loaded. Stocks: [$totalRows]");
        } catch (\LogicException $e) {
            $io->error($e->getMessage());
            return;
        }

        if ($isTest) {
            $io->success('Without insert to database.');
            return;
        } else {
            foreach($stocks as $stock) {
                try {
                    [
                        'Product Name' => $strProductName,
                        'Product Description' => $strProductDesc,
                        'Product Code' => $strProductCode,
                        'Stock' => $stockValue,
                        'Cost in GBP' => $cost,
                        'Discontinued' => $discontinued,
                    ] = $stock;
                } catch (ContextErrorException $e) {
                    ++$errorRows;
                    continue;
                }

                $stock = new Stock(
                    $strProductName,
                    $strProductDesc,
                    $strProductCode,
                    $stockValue,
                    $cost,
                    $discontinued
                );

                ++$insertRows;
                $em->persist($stock);
            }

            $em->flush();

            $io->block("Total rows: $totalRows");
            $io->block("Inserted rows: $insertRows");
            $io->block("Error rows: $errorRows");
            $io->success("Import completed.");
        }
    }

    /**
     * This method returns stocks content.
     *
     * @return mixed|null
     */
    private function getStocks() {
        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

        $path = $this->getContainer()->get('kernel')->getRootDir() . '/../csv_files/' . self::STOCK_FILENAME;
        $stocks = $serializer->decode(file_get_contents($path), 'csv');

        if (0 === count($stocks)) {
            throw new \LogicException('No data for import!');
        }

        return $stocks;
    }
}
