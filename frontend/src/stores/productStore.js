import { defineStore } from "pinia";
import api from "../services/api";

export const useProductStore = defineStore("product", {
  state: () => ({
    products: [],
    loading: false,
    error: null,
  }),
  actions: {
    async fetchProducts() {
      this.loading = true;
      this.error = null;

      try {
        const response = await api.get("/product");
        this.products = response.data.data;
      } catch (error) {
        this.error = error.message || "Error al cargar los productos";
        console.error("Error fetching products:", error);
      } finally {
        this.loading = false;
      }
    },

    async fetchProduct(id) {
      this.loading = true;
      this.error = null;

      try {
        const response = await api.get(`/product/${id}`);
        return response.data.data;
      } catch (error) {
        this.error = error.message || "Error al cargar el producto";
        console.error(`Error fetching product ${id}:`, error);
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async createProduct(product) {
      this.loading = true;
      this.error = null;

      try {
        const response = await api.post("/product", product);

        await this.fetchProducts();
        return response.data.data;
      } catch (error) {
        this.error = error.message || "Error al crear el producto";
        console.error("Error creating product:", error);
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async updateProduct(id, product) {
      this.loading = true;
      this.error = null;

      try {
        const response = await api.put(`/product/${id}`, product);

        const index = this.products.findIndex((p) => p.id === id);
        if (index !== -1) {
          this.products[index] = response.data.data;
        }

        await this.fetchProducts();
        return response.data.data;
      } catch (error) {
        this.error = error.message || "Error al actualizar el producto";
        console.error(`Error updating product ${id}:`, error);
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async deleteProduct(id) {
      this.loading = true;
      this.error = null;

      try {
        await api.delete(`/product/${id}`);
        this.products = this.products.filter((product) => product.id !== id);
        return true;
      } catch (error) {
        this.error = error.message || "Error al eliminar el producto";
        console.error(`Error deleting product ${id}:`, error);
        throw error;
      } finally {
        this.loading = false;
      }
    },
  },
});
