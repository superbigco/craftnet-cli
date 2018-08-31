<?php

namespace CraftnetCli\Command\CraftnetCli;

use CraftnetCli\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GetLicensesCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('licenses:list')
            ->setDescription('Get all licenses from Craftnet')
            ->setHelp('The command help text goes here');

        // extra command line arguments and options go here.
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client   = new Client();
        $response = $client->getLicenses();

        $body = json_decode($response->getBody(), true);

        $output->writeln(PrettyJson($body));
    }
}