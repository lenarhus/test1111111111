  /**
 * функция сортировки массива по 1 полю или N полей  от большего к меньшему
 *
 * @param string|array $keys
 *
 * @return int
 */
function sortFunction($keys)
{
    //если сортировка по нескольким полям
    if (is_array($keys))
    {
        return function ($a, $b) use ($keys)
        {
            foreach ($keys as $k) {
                if ($a[$k] != $b[$k]) {
                    return ($a[$k] < $b[$k]) ? 1 : -1;
                }
            }

            return 0;
        };
    }
    //если сортировка по одному полю
    else
    {
        return function ($a, $b) use ($keys)
        {
            if ($a[$keys] == $b[$keys]) {
                return 0;
            }
            return ($a[$keys] < $b[$keys]) ? 1 : -1;
        };
    }
}
usort($array, sortFunction($sortFields));
