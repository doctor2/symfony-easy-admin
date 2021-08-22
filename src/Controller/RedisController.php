<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RedisController extends AbstractController
{
    /**
     * @Route("/redis")
     */
    public function index(): Response
    {
        $redis = RedisAdapter::createConnection(
            'redis://localhost'
        );

        // Установка значения
        $redis->set('rate:GBP', 92);

        // Установим строку
        $redis->set('description:GBP', 'Pound sterling');

        // Установить значение, если таковое не существует
        // Если существует - ничего не делать
        // SET if Not eXists
        $redis->setnx('rate:GBP', 100);

        // Установить сразу несколько значений
        // Так же сработает msetnx
        $redis->mset([
            'rate:EUR' => 80,
            'rate:JPY' => 60,
        ]);

        // Значение будет храниться 60 секунд
        $redis->set('rate:USD', 77, 60);

        // Получить оставшееся время жизни значения
        $ttl = $redis->ttl('rate:USD');

        // Теперь значение будет храниться бесконечно
        $redis->persist('rate:USD');

        // Установить время жизни существующего значения
        $redis->expire('rate:USD', 3600);

        // Проверка на существование значения
        $exists = $redis->exists('rate:GBP');

        // Получение скалярного значения (строки)
        // Все скалярные значения в Redis - строки
        $value = $redis->get('rate:GBP');

        // Получить сразу несколько значений
        $values = $redis->mget([
            'rate:EUR',
            'rate:JPY',
        ]);

        // Удаление одного значения
        $quantity = $redis->del('rate:GBP');

        // Удаление нескольких значений
        $quantity = $redis->del('rate:GBP', 'rate:USD');
        $quantity = $redis->del(['rate:GBP', 'rate:USD']);


        /* Работа с числами */

        // Увеличиваем значение на 1
        $newValue = $redis->incr('rate:GBP');

        // Уменьшаем значение на 1
        $newValue = $redis->decr('rate:GBP');

        // Увеличиваем значение на N
        $newValue = $redis->incrBy('rate:GBP', 10);

        // Уменьшаем значение на N
        $newValue = $redis->decrBy('rate:GBP', 20);

        // Увеличение на дробные значения
        $newValue = $redis->incrByFloat('rate:GBP', 1.5);


        /* Работа со строками */

        // У юникод-символов переменная длина! Всегда помним об этом!

        $redis->set('description:GBP', 'Pound sterling');

        // Дописать строку
        $redis->append('description:GBP', ' (Great Britan)');
        $value = $redis->get('description:GBP');
        // $value = "Pound sterling (Great Britan)"

        // Получить часть строки
        $value = $redis->getRange('description:GBP', 0, 4);
        // $value = "Pound"

        $redis->setRange('description:GBP', 6, 'Sterling');
        $value = $redis->get('description:GBP');
        // $value = "Pound Sterling (Great Britan)"


        /* Работа со списками (push + range) */

        // Добавление значений в список "справа"
        $redis->rPush('popular', 'GBP');
        $redis->rPush('popular', 'USD');

        // Получение значений из списка
        // В данном случае - всех значений
        $populars = $redis->lRange('popular', 0, -1);
        // $populars = ["GBP", "USD"]

        // Добавление значений в список "слева"
        $redis->lPush('popular', 'EUR');
        $populars = $redis->lRange('popular', 0, -1);
        // $populars = ["EUR", "GBP", "USD"]

        // Тут получаем срез с 1 по 2 элемент, опуская 0 и все после 2
        $populars = $redis->lRange('popular', 1, 2);
        // $populars = ["GBP", "USD"]


        /* Работа со списками (index + len + set) */

        // Получение значения по индексу списка
        $popular = $redis->lIndex('popular', 0);
        // $popular = "EUR"

        // Получить длину списка
        $popularLength = $redis->lLen('popular');
        // $popularLength = 3

        // Установка значения по индексу
        $redis->lSet('popular', 0, 'JPY');
        $populars = $redis->lRange('popular', 0, -1);
        // $populars = ["JPY", "GBP", "USD"]


        /* Работа со списками (rem + trim) */

        // Удаление элементов по значению. Последний атрибут - количество удаляемых элементов.
        $redis->lRem('popular', 'USD', 1);
        $populars = $redis->lRange('popular', 0, -1);
        // $populars = ["JPY", "GBP"]

        // lTrim для списков работает аналогично lRange
        // Но не просто возвращает кусок списка, а меняет его
        $redis->lTrim('popular', 1, 1);
        $populars = $redis->lRange('popular', 0, -1);
        // $populars = ["GBP"]


        /* Работа со списками (pop) */

        $redis->rPush('popular', 'JPY', 'USD', 'EUR');
        $populars = $redis->lRange('popular', 0, -1);
        // $populars = ["GBP", "JPY", "USD", "EUR"]

        // Извлечение элемента "слева"
        $mostPopular = $redis->lPop('popular');
        // $mostPopular = "GBP"


        $populars = $redis->lRange('popular', 0, -1);
        // $populars = ["JPY", "USD"]

        // Извлечение элемента "справа"
        $lastPopular = $redis->rPop('popular');
        // $lastPopular = "EUR"

        $populars = $redis->lRange('popular', 0, -1);
        // $populars = ["JPY", "USD"]


        /* Работа с хешем (key-value) */

        $redis->hSet('change:GBP', 'amount', 1);
        $redis->hSet('change:GBP', 'time', '2020-03-20 14:23:10');
        $gbpChange = $redis->hGetAll('change:GBP');
        // array(2) {
        //  ["amount"]=>
        //  string(1) "1"
        //  ["time"]=>
        //  string(19) "2020-03-20 14:23:10"
        //}     
        
        $redis->hMSet("change:USD", [
            'amount' => 3,
            'time' => '2020-03-20 15:13:45'
         ]);
         $usdChange = $redis->hGetAll('change:USD');
         // array(2) {
         //  ["amount"]=>
         //  string(1) "3"
         //  ["time"]=>
         //  string(19) "2020-03-20 15:13:45"
         // }

         // Получение значения по ключу
        $gbpChangeAmount = $redis->hGet('change:GBP', 'amount');
        // $gbpChangeAmount = "1"

        // Получение количества элементов в списке
        $len = $redis->hLen('change:GBP');
        // $len = 2

        // Удаление элемента
        $redis->hDel('change:GBP', 'amount');
        $gbpChange = $redis->hGetAll('change:GBP');
        // array(1) {
        //  ["time"]=>
        //  string(19) "2020-03-20 14:23:10"
        //}

        // Проверка на существование
        $exists = $redis->hExists('change:GBP', 'amount');
        // $exists = false

        return new Response('success!');
    }
}
