namespace common\mappers;

use common\entities\Car;
use common\entities\CarOption;

class CarDataMapper
{
    public static function mapToArray(Car $car): array
    {
        $result = [
            'id' => $car->id,
            'title' => $car->title,
            'description' => $car->description,
            'price' => $car->price,
            'photo_url' => $car->photo_url,
            'contacts' => $car->contacts,
            'created_at' => $car->created_at,
        ];

        if ($car->options) {
            $result['options'] = array_map(function(CarOption $option) {
                return [
                    'brand' => $option->brand,
                    'model' => $option->model,
                    'year' => $option->year,
                    'body' => $option->body,
                    'mileage' => $option->mileage,
                ];
            }, $car->options);
        }

        return $result;
    }
}