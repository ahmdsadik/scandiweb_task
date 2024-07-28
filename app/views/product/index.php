<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container py-3">
    <form action="/product" method="post">
        <input type="hidden" name="_method" value="DELETE">
        <div class="d-flex justify-content-between align-item-center border-bottom border-black mb-3">

            <h1>Product List</h1>
            <div>
                <a href="/add-product" type="button" class="btn btn-primary rounded-0" id="add-product-btn">ADD</a>
                <button type="submit" class="btn btn-danger rounded-0" id="delete-product-btn">MASS DELETE
                </button>
            </div>
        </div>

        <div class="row gy-4">
            <?php foreach ($products as $product): ?>

                <div class="col-md-3">
                    <div class="card pb-4 rounded-0">
                        <div class="card-body">
                            <input type="checkbox" class="form-check-input rounded-0 delete-checkbox" value="<?= $product->getSku() ?>" name="deleted[]">
                            <div class="text-center">
                                <h5 class="card-title"><?= $product->getSku() ?></h5>
                                <p class="card-text mb-1"><?= $product->getName() ?></p>
                                <p class="card-text mb-1"><?= $product->getPrice() ?> $</p>
                                <p class="card-text mb-1"><?= $product->getAttrName() ?>
                                    : <?= $product->getAttrValue() ?></p>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
