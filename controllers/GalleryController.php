<?php

class GalleryController extends PageController
{
    public function action_main(): void
    {
        $this->action_index();
    }

    public function action_index(): void
    {
        
        $photos = [
            [
                'title' => 'Тренажерна зала',
                'category' => 'Силові тренажери',
                'url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNrmDJ3RDB_JZahdWtNdbMQ72P7QVqTYL7Nc4ZRgCFYQ&s=10'
            ],
            [
                'title' => 'Зона вільних ваг',
                'category' => 'Гантелі та штанги',
                'url' => 'https://kalushcity.gov.ua/assets/catalog/000/000/186/1618402657_932c47a8b0dbd62604a6_large.jpg'
            ],
            [
                'title' => 'Кардіо зона',
                'category' => 'Бігові доріжки',
                'url' => 'https://r2.sportlife.ua/Troeshina_3_3c71c190c8.jpg'
            ],
            [
                'title' => 'Кросфіт зона',
                'category' => 'Функціональний тренінг',
                'url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQh3HKRXROdtK9fvlatYdM6W-4ZgVrP-oms5OhGuzKSsQ&s'
            ],
            [
                'title' => 'Зал для групових занять',
                'category' => 'Йога та фітнес',
                'url' => 'https://5element.ua/i/news/1996/img_0026__large.jpg'
            ],
            [
                'title' => 'Зона відпочинку',
                'category' => 'Фітнес-бар',
                'url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQo65pcjp160ew5UjNrNvxUr7W4CxXdqEkfh6VcnRl8sw&s=10'
            ]
        ];

        $this->render('gallery/index', [
            'photos' => $photos
        ], 'Галерея залу — GymMaster');
    }
}