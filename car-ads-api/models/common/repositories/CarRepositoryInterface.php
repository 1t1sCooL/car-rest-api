namespace common\repositories;

use common\entities\Car;

interface CarRepositoryInterface
{
    public function save(Car $car): Car;
    public function findById(int $id): ?Car;
    public function findAll(int $page = 1, int $perPage = 10): array;
}