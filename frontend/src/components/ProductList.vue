<template>
  <div>
    <h1>Gestión de Productos</h1>
    <button @click="goToCreateProduct">Crear Producto</button>
    <ul v-if="!store.loading">
      <li v-for="product in store.products" :key="product.id">
        {{ product.name }}
        <button @click="editProduct(product.id)">Editar</button>
        <button @click="deleteProduct(product.id)">Eliminar</button>
      </li>
    </ul>
    <p v-else>Cargando...</p>
    <p v-if="store.error">{{ store.error }}</p>
  </div>
</template>

<script>
import { useProductStore } from "@/stores/productStore";
import { useRouter } from "vue-router";
import { onMounted } from "vue";

export default {
  setup() {
    const store = useProductStore();
    const router = useRouter();

    onMounted(async () => {
      await store.fetchProducts();
    });

    const goToCreateProduct = () => {
      router.push("/products/new");
    };

    const editProduct = (id) => {
      router.push(`/products/${id}/edit`);
    };

    const deleteProduct = async (id) => {
      try {
        await store.deleteProduct(id);
        // Recargar productos después de eliminar
        await store.fetchProducts();
      } catch (error) {
        console.error("Error al eliminar el producto", error);
      }
    };

    return {
      store, // Devolver todo el store como reactivo
      goToCreateProduct,
      editProduct,
      deleteProduct,
    };
  },
};
</script>
