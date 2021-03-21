<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="<?php echo site_url(); ?>">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Shop</strong></div>
        </div>
    </div>
</div>
<div class="site-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-9 order-2">
                <div class="row">
                    <div class="col-md-12 mb-5">
                        <div class="float-md-left mb-4"><h2 class="text-black h5">Shop All</h2></div>
                        <div class="d-flex">
                            <div class="dropdown mr-1 ml-md-auto">
                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuOffset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    View
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                    <a class="dropdown-item" onclick="document.getElementById('view').value = '';document.getElementById('filter-form').submit();" href="#">Grid</a>
                                    <a class="dropdown-item" onclick="document.getElementById('view').value = 'list';document.getElementById('filter-form').submit();" href="#">List</a>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" id="dropdownMenuReference" data-toggle="dropdown">Reference</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                    <a class="dropdown-item" onclick="document.getElementById('sort').value = '';document.getElementById('filter-form').submit();" href="#">Relevance</a>
                                    <a class="dropdown-item" onclick="document.getElementById('sort').value = 'name=asc';document.getElementById('filter-form').submit();" href="#">Name, A to Z</a>
                                    <a class="dropdown-item" onclick="document.getElementById('sort').value = 'name=desc';document.getElementById('filter-form').submit();" href="#">Name, Z to A</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" onclick="document.getElementById('sort').value = 'price=asc';document.getElementById('filter-form').submit();" href="#">Price, low to high</a>
                                    <a class="dropdown-item" onclick="document.getElementById('sort').value = 'price=desc';document.getElementById('filter-form').submit();" href="#">Price, high to low</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <?php if(!empty($products)) { ?>
                        <?php foreach ($products as $key => $product) { ?>
                            <?php $this->load->view('front/shop/_product', ['product' => $product]); ?>
                        <?php } ?>
                    <?php } ?>
                </div>
                <div class="row" data-aos="fade-up">
                    <div class="col-md-12 text-center">
                        <div class="site-block-27">
                            <?php echo $pagination; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 order-1 mb-5 mb-md-0">
                <form id="filter-form">
                    <div class="sidebar-style mr-30 filters">
                        <input type="hidden" name="view" id="view" value="<?php echo $this->input->get('view'); ?>">
                        <input type="hidden" name="sort" id="sort" value="<?php echo $this->input->get('sort'); ?>">
                        <div class="border p-4 rounded mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Search</h3>
                            <div class="input-group mb-3">
                                <input type="text" placeholder="Search here..." class="form-control" name="search" value="<?php echo $this->input->get('search'); ?>">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary p-2"><i class="icon icon-search2"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="border p-4 rounded mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Categories</h3>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-1 <?php echo ($this->input->get('category_id') == '') ? 'active' : ''; ?>">
                                    <label class="filter-label d-block">
                                        <input type="radio" name="category_id" onclick="$('#filter-form').submit();" value="" <?php echo ($this->input->get('category_id') == '') ? 'checked' : ''; ?>>
                                        <span>All</span>
                                    </label>
                                </li>
                                <?php if(!empty($categories)) { ?>
                                    <?php foreach ($categories as $key => $category) { ?>
                                        <?php if($category['total_products'] > 0) { ?>
                                            <li class="mb-1 <?php echo ($this->input->get('category_id') == $category['id']) ? 'active' : ''; ?>">
                                                <label class="filter-label d-block">
                                                    <input type="radio" name="category_id" onclick="$('#filter-form').submit();" value="<?php echo $category['id']; ?>" <?php echo ($this->input->get('category_id') == $category['id']) ? 'checked' : ''; ?>>
                                                    <span><?php echo $category['name']; ?></span>
                                                </label>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="border p-4 rounded mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Filter by Price</h3>
                            <div id="slider-range" class="border-primary"></div>
                            <input type="text" name="price" id="amount" class="form-control border-0 pl-0 bg-white" />
                            <button class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    $min_price_set = floor($min['price']);
    $max_price_set = ceil($max['price']);
    $price_data = explode(" - ", $this->input->get('price'));

    if(!empty($price_data) && count($price_data) == 2)
    {
        $min_price_set = trim($price_data[0], CURRENCY_CODE." ");
        $max_price_set = trim($price_data[1], CURRENCY_CODE." ");
    }
?>

<script>
    var sliderrange = $('#slider-range');
    var amountprice = $('#amount');

    $(function() {

        sliderrange.slider({
            range: true,
            min: <?php echo floor($min['price']); ?>,
            max: <?php echo ceil($max['price']); ?>,
            values: [<?php echo $min_price_set; ?>, <?php echo $max_price_set; ?>],
            slide: function(event, ui) {
                amountprice.val("<?php echo CURRENCY_CODE; ?> " + ui.values[0] + " - <?php echo CURRENCY_CODE; ?> " + ui.values[1]);
            }
        });

        amountprice.val("<?php echo CURRENCY_CODE; ?> " + sliderrange.slider("values", 0) + " - <?php echo CURRENCY_CODE; ?> " + sliderrange.slider("values", 1));
    });
</script>