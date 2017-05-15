<?php
// src/AppBundle/Command/CreateUserCommand.php
namespace AppBundle\Command;

use AppBundle\Entity\Recipe;
use AppBundle\Service\PackImpl;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetRecipeCommand extends ContainerAwareCommand
{
protected function configure()
{
 $this->setName('recipe:get');
}

protected function execute(InputInterface $input, OutputInterface $output)
{
    $this->doctrine = $this->getContainer()->get('doctrine');
    $em = $this->doctrine->getManager();
    $recipeRepository = $this->doctrine->getRepository('AppBundle:Recipe');
    $recipes = $recipeRepository->findAll();
    $nbrRecipe = count($recipes);
    $packImpl = new PackImpl($this->doctrine);
    $maxResult = $packImpl->getTotalRecipe();

    if($maxResult > $nbrRecipe) {
        $end = end($recipes);
        $data = $packImpl->makeRequest(array('maxResult' => 500,'start'=>$end->getId()));
        $progressBar = new ProgressBar($output, count($data['matches']));
        $progressBar->start();
        foreach ($data['matches'] as $item) {
            $newRecipe = new Recipe();
            $newRecipe->setIdAPI($item['id']);
            $newRecipe->setName($item['recipeName']);
            $newRecipe->setRate($item['rating']);
            $newRecipe->setTime($item['totalTimeInSeconds']);
            if(isset($item['attributes']['cuisine'])){
                $newRecipe->setCuisine($item['attributes']['cuisine']);
            }
            $em->persist($newRecipe);
            $em->flush();
            $progressBar->advance();
        }
        $progressBar->finish();
    }
}
}