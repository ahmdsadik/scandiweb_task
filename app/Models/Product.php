<?php

namespace App\Models;

class Product extends Model
{
    protected ?int $id;
    protected ?string $sku;
    protected ?string $name;
    protected ?string $price;
    protected ?string $attr_name;
    protected ?string $attr_value;

    /**
     * Product Model table name
     *
     * @var string
     */
    public static string $tableName = 'products';

    /**
     * Product Model primary key
     *
     * @var string
     */
    public static string $primaryKey = 'id';

    /**
     * Product Table Columns
     *
     * @var array
     */
    protected static array $tableSchema = [
        'name' ,
        'sku' ,
        'price' ,
        'attr_name' ,
        'attr_value' ,
    ];

    /**
     * @param string|null $sku
     * @param string|null $name
     * @param string|null $price
     */
    public function __construct(?string $sku, ?string $name, ?string $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string|null $sku
     * @return void
     */
    public function setSku(?string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return void
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     * @return void
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string|null
     */
    public function getAttrName(): ?string
    {
        return ucfirst($this->attr_name);
    }

    /**
     * @param string|null $attr_name
     * @return void
     */
    public function setAttrName(?string $attr_name): void
    {
        $this->attr_name = $attr_name;
    }

    /**
     * @return string
     */
    public function getAttrValue(): string
    {
        return match ($this->attr_name) {
            'size' => "{$this->attr_value} MB",
            'weight' => "{$this->attr_value}KG",
            default => "$this->attr_value",
        };
    }

    /**
     * @param string|null $attr_value
     * @return void
     */
    public function setAttrValue(?string $attr_value): void
    {
        $this->attr_value = $attr_value;
    }

    /**
     * Create a product
     *
     * @param $data
     * @return void
     */
    public static function make($data): void
    {
        /**
         * @var Product $product_class
         */

        $product_class = 'App\\Models\\' . $data['type'];

        $product = new $product_class($data);

        $product->create();
    }
}