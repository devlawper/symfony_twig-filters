<?php


namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

// Création d'un class étendue de AbstractExtension de Twig
class TwigBootstrapExtension extends AbstractExtension
{
    // Création d'une fonction qui sert à déclarer, le ou les filtres créés
    public function getFilters()
    {
        return [
            new TwigFilter('badge', [$this, 'badgeFilter'], ['is_safe' => ['html']]),
            new TwigFilter('booleanBadge', [$this, 'booleanBadgeFilter'], ['is_safe' => ['html']])
        ];
    }

    // Création de la fonction qui va retourner le contenu du filtre
    // $content est la variable que l'on passer à Twig
    public function badgeFilter($content, array $options = []) : string
    {
        // On crée un tableau de valeurs par défaut
        $defaultOptions = [
            'color' => 'primary',
            'rounded' => false
        ];

        // On merge la tableau par défaut et celui passer par l'utilisateur qui, si il existe, ecrasera les valeurs par défaut
        $options = array_merge($defaultOptions, $options);

        // On récupère la valeur de color dans le tableau $options
        $color = $options['color'];
        // Si true a été passé à rounded, alors on ajoute la class badge-pill au span, sinon rien
        $pill = $options['rounded'] ? ' badge-pill' : '';
        // Utilisation d'un template
        $template = '<span class="badge badge-%s %s">%s</span>';

        return sprintf(
            $template,
            $color,
            $pill,
            $content
        );
    }

    // Filtre conditionnel
    public function booleanBadgeFilter(bool $content, array $options = []) : string
    {
        // On crée un tableau de valeurs par défaut
        $defaultOptions = [
            'color' => 'primary',
            'rounded' => false
        ];

        // On merge la tableau par défaut et celui passer par l'utilisateur qui, si il existe, ecrasera les valeurs par défaut
        $options = array_merge($defaultOptions, $options);

        if ($content) {
            return $this->badgeFilter('Oui');
        } else {
            return $this->badgeFilter('Non', ['color' => 'danger']);
        }
    }
}