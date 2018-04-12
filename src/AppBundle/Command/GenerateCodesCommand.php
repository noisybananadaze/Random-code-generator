<?php

namespace AppBundle\Command;

use AppBundle\Entity\CodeSettings;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class GenerateCodesCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName('generateCodes')
            ->setDescription('Default filename - result.txt')
            ->addArgument('numberOfCodes', InputArgument::REQUIRED, 'Number of codes.')
            ->addArgument('length', InputArgument::REQUIRED, 'Length of codes.')
            ->addOption('fileName', null, InputOption::VALUE_REQUIRED, 'File name');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $codeSettings = new CodeSettings();
        $codeSettings->numberOfCodes = (int) $input->getArgument('numberOfCodes');
        $codeSettings->length = (int) $input->getArgument('length');

        try {
            $codeGenerator = $this->getContainer()->get('app.code_generator');
            $codeGenerator->setParameters($codeSettings);
            if ($input->getOption('fileName')) {
                $codeGenerator->setFileName($input->getOption('fileName'));
            }
            else {
                $codeGenerator->setFileName('result.txt');
            }
            $codeGenerator->generateCodes();
            $output->writeln('Success');
        } catch (\Exception $e) {
            $output->writeln($e->getMessage());
        }
    }

}