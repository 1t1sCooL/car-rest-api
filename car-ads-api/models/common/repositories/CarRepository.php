namespace common\repositories;

use common\entities\Car;
use common\entities\CarOption;
use yii\db\Connection;

class CarRepository implements CarRepositoryInterface
{
    private $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    public function save(Car $car): Car
    {
        $transaction = $this->db->beginTransaction();
        
        try {
            $this->db->createCommand()
                ->insert('car', [
                    'title' => $car->title,
                    'description' => $car->description,
                    'price' => $car->price,
                    'photo_url' => $car->photo_url,
                    'contacts' => $car->contacts,
                ])
                ->execute();

            $car->id = $this->db->getLastInsertID();

            if ($car->options) {
                foreach ($car->options as $option) {
                    $this->db->createCommand()
                        ->insert('car_option', [
                            'car_id' => $car->id,
                            'brand' => $option->brand,
                            'model' => $option->model,
                            'year' => $option->year,
                            'body' => $option->body,
                            'mileage' => $option->mileage,
                        ])
                        ->execute();
                }
            }

            $transaction->commit();
            return $car;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function findById(int $id): ?Car
    {
        $carData = $this->db->createCommand(
            "SELECT * FROM car WHERE id = :id",
            [':id' => $id]
        )->queryOne();

        if (!$carData) {
            return null;
        }

        $optionsData = $this->db->createCommand(
            "SELECT * FROM car_option WHERE car_id = :car_id",
            [':car_id' => $id]
        )->queryAll();

        $options = [];
        foreach ($optionsData as $optionData) {
            $options[] = new CarOption(
                $optionData['brand'],
                $optionData['model'],
                $optionData['year'],
                $optionData['body'],
                $optionData['mileage']
            );
        }

        $car = new Car(
            $carData['title'],
            $carData['description'],
            $carData['price'],
            $carData['contacts'],
            $carData['photo_url'],
            $options ?: null
        );
        $car->id = $carData['id'];
        $car->created_at = $carData['created_at'];

        return $car;
    }

    public function findAll(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;

        $carsData = $this->db->createCommand(
            "SELECT * FROM car ORDER BY created_at DESC LIMIT :limit OFFSET :offset",
            [':limit' => $perPage, ':offset' => $offset]
        )->queryAll();

        $cars = [];
        foreach ($carsData as $carData) {
            $car = new Car(
                $carData['title'],
                $carData['description'],
                $carData['price'],
                $carData['contacts'],
                $carData['photo_url']
            );
            $car->id = $carData['id'];
            $car->created_at = $carData['created_at'];
            $cars[] = $car;
        }

        return $cars;
    }
}