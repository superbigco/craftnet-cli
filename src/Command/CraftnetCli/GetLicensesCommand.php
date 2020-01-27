<?php

namespace CraftnetCli\Command\CraftnetCli;

use CraftnetCli\Client;
use CraftnetCli\Credentials;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetLicensesCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('licenses:list')
            ->setDescription('Get all licenses from Craftnet');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $credentials = new Credentials($output);
        $client      = new Client();
        $response    = $client->getLicenses();

        $body = json_decode($response->getBody(), true);

        $output->writeln(PrettyJson($body));

        return 0;
    }
}