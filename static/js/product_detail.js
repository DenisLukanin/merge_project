const App = Vue.createApp({});
App.component("product", {
    data() {
        return {
            id:"",
            title: "",
            photo: "",
            price: 0,
            description: "",
        }
    },
    props: ["product_id"],
    created: function(){
        fetch("/catalog/rest/product/get/"+ this.product_id +"/")
            .then( response  => response.json())
            .then( product  => {
                this.id = product["id"],
                this.title = product["title"],
                this.photo = "../../"+product["photo"],
                this.price = product["price"],
                this.description = product["description"]
            });
    },
    template: `
    <div class="flex_vrap">
        <img class="photo" :src="photo" :alt="title" >
        <div class="decription">
            <h1 class="title">{{ title }}</h1>
            <p class="text">{{ description }}</p>
            <span class="price">{{ price }} р.</span>
        </div>
    </div>`
});
App.mount('#app');


