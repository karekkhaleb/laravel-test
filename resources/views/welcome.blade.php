<!doctype html>
<html lang="{{ app()->getLocale() }}" xmlns:v-bind="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/axios.js') }}"></script>
    </head>
    <body>

    <div id="app" class="container app">
        <did class="form">

            <form @submit="submitForm">
                <did class="form-group">
                    <label for="productname">Product Name:</label>
                    <input type="text" name="productName" id="productname" class="form-control" :value="productName" v-model="productName">

                </did>
                <did class="form-group">
                    <label for="quantityinstock">Quantity in stock:</label>
                    <input type="text" name="quantityInStock" id="quantityinstock" class="form-control" :value="quantityInStock"  v-model="quantityInStock">
                </did>
                <did class="form-group">
                    <label for="priceperitem">Price per item:</label>
                    <input type="text" name="pricePerItem" id="priceperitem" class="form-control" :value="pricePerItem"  v-model="pricePerItem">

                </did>
                <did class="form-group">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </did>
            </form>
        </did>
        <div class="list">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <table class="table-responsive table-bordered table">
                        <tr>
                            <td>Product Name</td>
                            <td>Quantity in Stock</td>
                            <td>Price per Item</td>
                            <td>Datetime submitted</td>
                            <td>Total Value number</td>
                        </tr>
                        <tr  v-for="product in products" >
                            <td>@{{ product.productName }}</td>
                            <td>@{{ product.quantityInStock }}</td>
                            <td>@{{ product.pricePerItem }}</td>
                            <td>@{{ product.dateTimeSubmitted }}</td>
                            <td>@{{ product.quantityInStock * product.pricePerItem }}</td>
                        </tr>
                        <tr >
                            <td>Total Value numbers</td><td colspan="4">@{{ totalValueNumber }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--<script src="{{ asset('js/js.js') }}"></script>--}}
    <script type="text/javascript">

        const app = new Vue({
            el: '#app',
            modal:'development',
            data: {
                productName:'',
                quantityInStock: "",
                pricePerItem:'',
                products:[]
            },
            created: function () {
                this.fetchData();
            },
            methods:{
                submitForm: function(e){
                    e.preventDefault();
                    let newProduct = {};
                    newProduct.productName = this.productName;
                    newProduct.pricePerItem = this.pricePerItem;
                    newProduct.quantityInStock = this.quantityInStock;
                    newProduct.dateTimeSubmitted = new Date().toLocaleString();
                    // this.products.push(newProduct);
                    this.products.push(newProduct);
                    axios({
                        method: 'post',
                        url: 'createProduct',
                        headers:{
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        data: this.products
                    }).then(res=> {
                        this.productName = '';
                        this.quantityInStock = "";
                        this.pricePerItem ='';
                        // let products = JSON.parse(res.data).products;

                    })
                        .catch(error=> console.log(error));
                    this.productName = '';
                    this.quantityInStock = "";
                    this.pricePerItem ='';
                },
                fetchData: function () {
                    axios.get('getProducts')
                        .then(function (data) {
                            return JSON.parse(data.data);
                    }).then(data=>{
                        this.products = data.products;
                        console.log(data);
                    })
                        .catch(error=>console.log(error));
                }
            },
            computed:{
                totalValueNumber: function () {
                    let totalValueNumber = 0;
                    this.products.forEach(product=>{
                       let valueNumber = product.quantityInStock * product.pricePerItem;
                       totalValueNumber += valueNumber;
                    });
                    return totalValueNumber;
                }
            }
        });
    </script>
    </body>
</html>
