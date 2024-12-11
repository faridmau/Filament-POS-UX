<x-filament-panels::page>
    <div class="flex lg:flex-row flex-col-reverse" x-data="initPos({{ json_encode($categories) }}, {{ json_encode($products) }}, '{{ $currency }}')">

        <!-- Left Section -->
        <div class="w-full lg:w-3/5 min-h-screen">
            <x-filament::section>
                <x-slot name="heading">
                    <div class="flex justify-between items-center px-5 mt-5">
                        <div>
                            <x-filament::input.wrapper>
                                <x-filament::input type="text" x-model="search" placeholder="Search products..." />
                            </x-filament::input.wrapper>

                        </div>
                        <div class="flex items-center">
                            <div class="text-sm text-center mr-4">
                                <div class="text-gray-500">Last synced</div>
                                <span class="font-semibold">3 mins ago</span>
                            </div>
                            <x-filament::button size="lg" color="gray">Sync</x-filament::button>
                        </div>
                    </div>
                </x-slot>

                <!-- Categories -->
                <div class="mt-5 flex px-5">
                    <span @click="selectCategory(0)" class="cursor-pointer px-5 py-1 rounded-2xl text-sm mr-4"
                        :class="category_select === 0 ? 'text-white bg-yellow-500' : 'bg-gray-200'">
                        All Items
                    </span>
                    <template x-for="category in categories" :key="category.id">
                        <span @click="selectCategory(category.id)"
                            class="cursor-pointer px-5 py-1 rounded-2xl text-sm mr-4"
                            :class="category_select === category.id ? 'text-white bg-yellow-500' : 'bg-gray-200'">
                            <span x-text="category.name"></span>
                        </span>
                    </template>
                </div>

                <!-- Products -->
                <div class="grid grid-cols-3 gap-4 px-5 mt-5">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div @click="addOrder(product)"
                            class="cursor-pointer px-3 py-3 flex flex-col border border-gray-200 rounded-md h-32 justify-between">
                            <div>
                                <div class="font-bold text-gray-800" x-text="product.name"></div>
                                <span class="text-sm text-gray-400">Category: <span
                                        x-text="product.category_id"></span></span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold text-yellow-500"
                                    x-text="currency + product.price.toFixed(2)"></span>
                                <img :src="product.thumbnail" class="h-14 w-14 object-cover rounded-md"
                                    alt="Product Image">
                            </div>
                        </div>
                    </template>

                </div>
            </x-filament::section>
        </div>

        <!-- Right Section -->
        <div class="w-full lg:w-2/5 ml-5">
            <x-filament::section>

                <x-slot name="heading">
                    <!-- Current Order Header -->
                    <div class="flex justify-between items-center px-5 mt-5">
                        <div>
                            <h2 class="text-xl font-bold">Current transaction</h2>
                            <span class="text-xs text-gray-500">Order ID#SIMON123</span>
                        </div>
                        <x-filament::button x-show="orders.length > 0"
                            @click="$dispatch('open-modal', { id: 'delete-confirmation' })"
                            class="bg-red-500 text-white" color="danger">
                            Clear
                        </x-filament::button>
                    </div>
                </x-slot>

                <!-- Order List -->
                <div class="px-5 py-4 mt-5 max-h-[35rem] overflow-y-auto">

                    <template x-for="order in orders" :key="order.id">
                        <div class="flex justify-between items-center mb-4">
                            <div class="flex items-center w-2/5">
                                <img :src="order.thumbnail" class="w-10 h-10 object-cover rounded-md" alt="">
                                <span class="ml-4 font-semibold text-sm" x-text="order.name"></span>
                            </div>
                            <div class="w-32 flex justify-between">
                                <button @click="decrease(order)" class="px-3 py-1 bg-gray-300 rounded-md">-</button>
                                <span class="font-semibold mx-4" x-text="order.quantity"></span>
                                <button @click="increase(order)" class="px-3 py-1 bg-gray-300 rounded-md">+</button>
                            </div>
                            <span class="text-lg font-semibold text-center w-16"
                                x-text="currency + order.total.toFixed(2)"></span>
                        </div>
                    </template>
                    <div x-show="orders.length == 0">
                        <div class="flex justify-center items-center h-32 w-full border border-gray-200 rounded-md">
                            <span class="text-gray-400">No order found</span>
                        </div>
                    </div>
                </div>
            </x-filament::section>


            <!-- Total Section -->
            <div class="px-5 mt-5">
                <div class="py-4 shadow-lg rounded-md">
                    <div class="border-t-2 mt-3 py-2 px-4 flex justify-between items-center">
                        <span class="text-2xl font-semibold">Total</span>
                        <span class="text-2xl font-bold" x-text="currency + grandTotal.toFixed(2)"></span>
                    </div>
                </div>
            </div>

            <!-- Pay Button -->
            <div class="px-5 mt-5">
                <button :class="orders.length > 0 ? 'bg-yellow-500 cursor-pointer' : 'bg-gray-300 cursor-not-allowed'"
                    class="w-full py-4 rounded-md text-white font-semibold">
                    Pay with Cashless Credit
                </button>
            </div>
        </div>
        <x-filament::modal id="delete-confirmation">
            <x-slot name="heading">
                <h2 class="text-lg font-semibold text-gray-800">Clear All Orders</h2>
            </x-slot>

            <x-slot name="footerActions">
                <x-filament::button @click="$dispatch('close-modal', { id: 'delete-confirmation' });" class="mr-2">
                    Cancel
                </x-filament::button>
                <x-filament::button @click="clearOrders();$dispatch('close-modal', { id: 'delete-confirmation' });"
                    class="bg-red-500 text-white" color="danger">
                    Clear All
                </x-filament::button>
            </x-slot>
        </x-filament::modal>
    </div>

</x-filament-panels::page>

<script>
    function initPos(categories, products, currency) {
        return {
            categories,
            products,
            currency,
            category_select: 0,
            search: '',
            orders: [],

            get filteredProducts() {
                return this.products.filter(product =>
                    (this.category_select === 0 || product.category_id === this.category_select) &&
                    product.name.toLowerCase().includes(this.search.toLowerCase())
                );
            },
            addOrder(product) {
                let order = this.orders.find(o => o.id === product.id);
                if (order) {
                    this.increase(order);
                } else {
                    this.orders.push({
                        ...product,
                        quantity: 1,
                        total: product.price
                    });
                }
            },
            increase(order) {
                order.quantity++;
                order.total = order.quantity * order.price;
            },
            increase2() {
                alert('123');
            },
            decrease(order) {
                if (order.quantity > 1) {
                    order.quantity--;
                    order.total = order.quantity * order.price;
                } else {
                    this.orders = this.orders.filter(o => o.id !== order.id);
                }
            },
            clearOrders() {
                this.orders = [];
            },
            get grandTotal() {
                return this.orders.reduce((sum, order) => sum + order.total, 0);
            },
            selectCategory(id) {
                this.category_select = id;

            }
        };
    }
</script>
