<?php
// src/Twig/AppExtension.php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
  public function getFilters()
  {
    return [
      new TwigFilter('habitat_pretty', [$this, 'formatHabitat']),
    ];
  }

  public function formatHabitat($habitat)
  {
    switch ($habitat) {
      case 'HABITAT_SAVANNAH':
        return 'Savane';
      case 'HABITAT_JUNGLE':
        return 'Jungle';
      case 'HABITAT_SWAMP':
        return 'Marais';
      default:
        return 'Inconnu';
    }
  }
}
