class CarService {
    private CarRepository $repository;

    public function __construct(CarRepository $repository) {
        $this->repository = $repository;
    }

    public function createCar(array $data): Car {
        // Валидация, маппинг, сохранение
    }

    public function getCar(int $id): ?Car {
        return $this->repository->findById($id);
    }

    public function listCars(int $page): array {
        return $this->repository->findAll($page);
    }
}