<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommentCrudController extends AbstractCrudController
{
    private $basePath;

    public function __construct(string $photoDir) {
        $this->basePath = $photoDir;
    }

    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('conference'),
            TextField::new('author'),
            EmailField::new('email'),
            TextEditorField::new('text'),
            DateField::new('createdAt')->setFormat('short'),
            ImageField::new('photoFilename')->setBasePath('/uploads/photos')->setLabel('photo')->hideOnForm(),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('conference');
    }

}
