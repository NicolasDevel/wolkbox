import { createRouter, createWebHistory } from "vue-router";
import ProductList from "../components/ProductList.vue";
import ProductForm from "../components/ProductForm.vue";

const routes = [
  {
    path: "/",
    name: "Home",
    component: ProductList,
  },
  {
    path: "/products/new",
    name: "CreateProduct",
    component: ProductForm,
  },
  {
    path: "/products/:id/edit",
    name: "EditProduct",
    component: ProductForm,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
