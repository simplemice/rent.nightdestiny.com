<?php


return [
    // English
    'en' => [

//		'car:header' => 'Оформление заказа',
//		'car:place_from' => 'Место подачи',
//		'car:date_from' => 'Дата подачи',
//		'car:time_from' => 'Время подачи',
//		'car:place_to' => 'Место возврата',
//		'car:date_to' => 'Дата возврата',
//		'car:time_to' => 'Время возврата',
//		'car:insurance' =>'Доп. страховка',
//		'car:kid_chair' =>'Детское кресло',
//		'car:phone_sim' => 'SIM card with internet',
//		'car:rent' => 'Rent price',
//		'car:discount' => 'Discount',
//		'car:delivery' => 'Delivery',
//		'car:options' => 'Доп. опции',
//		'car:total' => 'Total',
//
//		'client:name' => 'Your name',
//		'client:phone' => 'Phone',
//
//		'form:submit' => 'Place an order',
//
//		'transmission:auto' => 'AUTO',
//		'ac:1' => 'A/C',
//		'select' =>'Select',
//		'thankyou'=> 'Thank You',
//		'was-send'=> 'Your request has been sent successfully.',
//		'choose-region' => 'Select a region'
    ],
    // Russian
    'ru' => [
        'form:place_from' => 'Место подачи',
        'form:date_from' => 'Дата подачи',
        //'form:time_from' => 'Время получения',
        'form:place_to' => 'Место возврата',
        'form:date_to' => 'Дата возврата',
        //'form:time_to' => 'Время возврата',
        //'form:age' => 'Возраст водителя 25-70',
        'form:new_return' => 'Возврат в другом месте',
        'form:search' => 'ПОИСК',

#        'form:insurance' => 'Расширенная страховка',
#        'form:chair' => 'Детское кресло',
#        'form:sim' => 'SIM карта с интернетом',

        'invoice:rent' => 'Аренда',
        'invoice:discount' => 'Скидка',
        'invoice:delivery' => 'Подача и возврат',
        'invoice:deposit' => 'Депозит',
        'invoice:addons' => 'Доп. опции',
        'invoice:total' => 'Итого',

        'submit:name' => 'Имя',
        'submit:p_name' => 'Иван Иванов',
        'submit:phone' => 'Телефон с кодом',
        'submit:p_phone' => '+79876543210',
        'submit:place' => 'ЗАБРОНИРОВАТЬ',

        'found_cars' => 'Найдено лодок и яхт',
        'car:price_for_day' => 'в сутки',
        'car:total' => 'итого',

        'car-type:hatchback' => 'хэтчбэк',
        'car-type:sedan' => 'седан',
        'car-type:liftback' => 'лифбэк',
        'car-type:minivan' => 'минивэн',
        'car-type:jeep' => 'джип',

        'car:transmission' => 'АКПП',
        'car:ac' => 'Кондиционер',
        'car:year' => 'г.',
        'car:fuel' => 'Топливо',
        'car:consumption' => 'Расход',
        'car:discount' => 'Скидка',
        'car:toilet' => ' санузла',
        'car:snork' => 'Снорклинг, рыбалка',
        'car:seats' => 'мест + 2 экипаж',
        'select' => 'ВЫБРАТЬ',

        // car-review:1, where 1 is carId
        'car-review:1' => [
            [
                'name' => 'Василий Павлов',
                'description' => 'Была бюджетная поездка на Пхукет и пришлось снять самый дешевый по стоимости ТС Ниссан Альмера. Машина новая, но качество сборки и сами ощущения от вождения оставляют желать лучшего. Не пойму, как японцы могли сделать такой таз?',
            ],
        ],

        'car-review:2' => [
            [
                'name' => 'Андрей',
                'description' => 'Арендовал новый ТС похоже что привезли прямо из салона, пробег на одометре всего 54 километра. Вот это подход к делу, аж настроение улучшилось:) Ребята Вы молодцы, важно так и дальше держать.',
            ],
        ],

        'car-review:3' => [
            [
                'name' => 'Леонид',
                'description' => 'Для меня важно быть всегда на авто особенно на Пхукете, где нет адекватного социального транспорта и все нужные мне места расположены слишком далеко. Обзвонив несколько местных контор по прокату авто, я смог договориться только с менеджером манки кар, что бы мне не включали в оплату дни проведенные на экскурсиях, при условии что ТС будет стоять на парковке отеля. Иначе мне бы пришлось каждый раз сдавать и принимать ТС отдельно оплачивая доставку и возврат, что есть не очень хорошо. Спасибо за клиентоориентированный подход, уверен многим до Вас далеко!',
            ],
        ],

        // car-terms
        'car-terms-conditions' => 'Условия и положения',

        'car-terms' => 'Требования к арендатору',
        'car-terms-list' => '
        <p>Возраст водителя 23 - 65 лет.</p> 
        <p>Наличие действующего загранпаспорта с таможенной отметкой о прибытии и позволяющий легально находиться на территории Королевства Таиланд.</p>',
    ]
];
