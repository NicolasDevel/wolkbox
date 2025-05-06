<template>
  <div>
    <h1>{{ isEditing ? "Editar Producto" : "Crear Producto" }}</h1>
    <form @submit.prevent="handleSubmit">
      <label>
        Nombre:
        <input v-model="product.name" required />
      </label>
      <label>
        Precio:
        <input v-model="product.price" required type="number" />
      </label>
      <button type="submit">Guardar</button>
    </form>
  </div>
</template>

<script>
import router from "@/router";
import { useProductStore } from "@/stores/productStore";

export default {
  props: ["id"],
  setup(props) {
    const store = useProductStore();
    const product = { name: "", price: 0 };
    const isEditing = !!props.id;

    if (isEditing) {
      store.fetchProduct(props.id).then((data) => {
        Object.assign(product, data);
      });
    }

    const handleSubmit = () => {
      if (isEditing) {
        store.updateProduct(props.id, product);
      } else {
        store.createProduct(product);
      }

      router.push(`/`);
    };

    return { product, isEditing, handleSubmit };
  },
};
</script>
