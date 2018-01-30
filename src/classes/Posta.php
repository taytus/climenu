<?php

namespace taytus\climenu\classes;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;


class Posta extends Command{



    protected function configure(){
        $this->setName("FizzBuzz:FizzBuzz")
            ->setDescription("Runs Fizzbuzz");
    }

    protected function execute(InputInterface $input, OutputInterface $output){

        //$fizzy = new FizzBuzz();

        $helper = $this->getHelper('question');
        $question = new Question('Please select a limit for this execution: ', 25);
        $limit = $helper->ask($input, $output, $question);

        //$result = $fizzy->firstNFizzbuzz($limit);
    }
}

