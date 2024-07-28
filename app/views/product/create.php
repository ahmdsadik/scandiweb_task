<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Add</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

</head>
<body>

<div class="container py-3" x-data="Product">
    <form id="product_form" method="POST" action="/product" @submit="store(event)">
        <div class="d-flex justify-content-between align-item-center border-bottom border-black mb-3">
            <h1>Product Add</h1>
            <div>
                <button type="submit" class="btn btn-success rounded-0" id="save-product-btn">Save</button>
                <a href="/" class="btn btn-secondary rounded-0" id="cancel-btn">Cancel</a>
            </div>
        </div>

        <div class="col-5">
            <div class="row mb-4">
                <div class="col-4">
                    <label for="sku" class="form-label">SKU</label>
                </div>
                <div class="col-8">
                    <input required type="text" class="form-control" id="sku" name="sku" x-model="sku">

                    <span class="text-danger d-block mt-1" x-text="errors.sku"></span>

                </div>
            </div>
            <div class="row mb-4">
                <div class="col-4">
                    <label for="name" class="form-label">Name</label>
                </div>
                <div class="col-8">
                    <input required type="text" class="form-control" id="name" name="name" x-model="name">

                    <span class="text-danger d-block mt-1" x-text="errors.name"></span>

                </div>
            </div>
            <div class="row mb-4">
                <div class="col-4">
                    <label for="price" class="form-label">Price ($)</label>
                </div>
                <div class="col-8">
                    <input required type="number" class="form-control" id="price" name="price" x-model="price">

                    <span class="text-danger d-block mt-1" x-text="errors.price"></span>

                </div>
            </div>
            <div class="row mb-4">
                <div class="col-4">
                    <label for="productType" class="form-label" >Product Type</label>
                </div>
                <div class="col-8">
                    <select required class="form-select" id="productType" name="type" x-model="type"
                            @change="getProductAttributes">
                        <option selected value="">Select Product Type</option>
                        <?php foreach ($types as $type): ?>
                            <option value="<?= $type->name ?>"><?= $type->name ?></option>
                        <?php endforeach; ?>
                    </select>

                    <span class="text-danger d-block mt-1" x-text="errors.type"></span>

                </div>
            </div>

            <template x-for="(attribute, index) in attributes">


                <div class="row mb-4" :id="`${attribute.name}-${index}`">
                    <div class="col-4">
                        <label :for="attribute.name" class="form-label" x-text="attribute.label"></label>
                    </div>
                    <div class="col-8">
                        <input required type="number" class="form-control"
                               :id="attribute.name" :name="attribute.name">
                    </div>
                </div>
            </template>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('Product', () => ({
            name: '',
            sku: '',
            price: '',
            type: '',
            errors: {},
            attributes: {},
            getProductAttributes() {

                axios.get(`/product-attributes?type=${this.type}`)
                    .then((response) => {
                        // Handle successful response
                        this.attributes = response.data;
                    })
                    .catch((error) => {
                        // Handle error response
                        if (error.response.status === 419) {
                            this.errors = error.response.data.errors
                        }
                    });
            },
            store: async function(e) {
                // Prevent the default form submission
                e.preventDefault();

                this.errors = {};

                // Client-side validation
                if (!this.sku) {
                    this.errors.sku = 'Sku is required';
                }
                if (!this.name) {
                    this.errors.name = 'Name is required';
                }
                if (!this.price) {
                    this.errors.price = 'Price is required';
                }
                if (!this.type) {
                    this.errors.type = 'Product Type is required';
                }

                // If there are validation errors, stop the submission
                if (Object.keys(this.errors).length !== 0) {
                    return;
                }

                // Server-side validation
                try {
                    const response = await axios.post('/product-validate', {
                        name: this.name,
                        sku: this.sku,
                        price: this.price,
                        type: this.type,
                    });
                } catch (error) {
                    // Handle error response
                    if (error.response.status === 419) {
                        this.errors = error.response.data.errors;
                    }

                    return;
                }

                // Submit the form if no errors are found
                e.target.submit();
            }

        }))
    })
</script>

<!--<script>-->
<!--    $(document).ready(function () {-->
<!--        window.location.href = "/";-->
<!--    });-->
<!--</script>-->
</body>
</html>
