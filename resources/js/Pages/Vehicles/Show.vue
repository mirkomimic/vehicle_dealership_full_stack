<template>
  <Head title="Vehicle"/>
  <MainLayout>

    <v-overlay v-model="galleryOverlay" class="d-none d-md-flex items-center justify-center">
      <FullScreenVueCarouselGallery :vehicle="vehicle"/>
    </v-overlay>

    <v-container fluid class="pa-0 ma-0 ps-lg-10">
      <v-breadcrumbs
        :items="breadcrumbs"
        divider="/"
        icon="mdi-home"
      >
        <template v-slot:item="{item}">
          <v-breadcrumbs-item :disabled="item.disabled">
            <Link :href="item.href">{{ item.title }}</Link>
          </v-breadcrumbs-item>
        </template>
      </v-breadcrumbs>
    </v-container>

    <v-container>
      <v-row>
        <v-col
          cols="12"
          md="6"
        >
          <VueCarouselGallery 
            :vehicle="vehicle" v-model:gallery-overlay="galleryOverlay"
          />
        </v-col>
        <v-col
          cols="12"
          md="6"
          class="mt-md-15"
        >
          <v-btn
            v-if="vehicle.user_id == user?.id || user?.is_admin"
            @click="router.delete(route('vehicles.destroy', vehicle.id))"
            color="red-lighten-3"
            variant="outlined"
            density="compact"
            class="mb-3"
            >Delete Vehicle
          </v-btn>

          <v-table density="comfortable">
            <tbody>
              <tr>
                <td>ID</td>
                <td>{{ vehicle.id }}</td>
              </tr>
              <tr>
                <td>Year</td>
                <td>{{ vehicle.year }}</td>
              </tr>
              <tr>
                <td>Brand</td>
                <td>{{ vehicle.brand.name }}</td>
              </tr>
              <tr>
                <td>Model</td>
                <td>{{ vehicle.model.name }}</td>
              </tr>
              <tr>
                <td>Mileage</td>
                <td>{{ vehicle.mileage }}</td>
              </tr>
              <tr>
                <td>Price</td>
                <td>{{ formatPrice(vehicle.price) }}</td>
              </tr>
              <tr>
                <td>Created</td>
                <td>{{ new Date(vehicle.created_at).toLocaleDateString() }}</td>
              </tr>
            </tbody>
          </v-table>

          <v-btn 
            v-if="$page.props.auth.user && $page.props.auth.user.id != vehicle.user_id"
            @click="addToCart(vehicle)"
            variant="tonal"
            color="teal-lighten-3"
            class="mt-5"
            prepend-icon="mdi-plus"
            >Add to Cart
            <template v-slot:append>
              ({{ qtyOfVehicleInCart }})
            </template>
          </v-btn>
          <v-btn 
            v-if="qtyOfVehicleInCart"
            @click="removeFromCart(vehicle)"
            variant="tonal"
            color="red-lighten-3"
            class="mt-5 ms-2"
            prepend-icon="mdi-minus"
            >Remove from Cart
          </v-btn>
        </v-col>
      </v-row>

      <v-divider class="mt-10 mb-5"></v-divider>

      <div class="text-h4 text-teal-darken-3 mb-5">Comments</div>

      <v-textarea
        v-model="newCommentForm.comment"
        :rules="rules.length"
        counter
        label="Leave a comment..." 
        variant="outlined"
        color="teal-lighten-3"
        prepend-inner-icon="mdi-comment"
      ></v-textarea>
      <v-btn
        @click="submitNewComment"
        color="teal-darken-3"
        >Submit
      </v-btn>

      <v-divider class="my-5"></v-divider>

      <div v-if="comments.length" class="mt-3" style="height: 1000px; overflow: scroll;">
        <Comments
          v-for="comment in comments"
          :key="comment"
          :comment="comment" 
        />
      </div>

      <div v-else class="text-center font-weight-bold">No comments yet!</div>

    </v-container>
  </MainLayout>
</template>

<script setup>
import Comments from '@/Components/Comments/Comments.vue';
import FullScreenVueCarouselGallery from '@/Components/Gallery/FullScreenVueCarouselGallery.vue';
import VueCarouselGallery from '@/Components/Gallery/VueCarouselGallery.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps(['vehicle', 'comments', 'breadcrumbs'])

const cart = computed(() => usePage().props.cart)
const user = usePage().props.auth.user

const galleryOverlay = ref(false)

const rules = {
  length: [v => v.length <= 250 || 'Max 250 characters'],
}

const newCommentForm = useForm({
  vehicle_id: props.vehicle.id,
  comment: '',
})

const submitNewComment = () => {
  newCommentForm.post(route('comment.store'), {
    preserveScroll: true,
  })
  newCommentForm.reset()
}

const addToCart = (vehicle) => {
  router.post(route('cart.store'), {vehicle: vehicle})
}
const removeFromCart = (vehicle) => {
  router.post(route('cart.remove'), {vehicle: vehicle})
}

const formatPrice = (price) => {
  return price.toLocaleString("de-DE", { maximumFractionDigits: 2, minimumFractionDigits: 2 })
}


const qtyOfVehicleInCart = computed(() => {
  let item = cart.value.find((item) => {
    return item.vehicle.id == props.vehicle.id
  })
  return item ? item.quantity : 0
})
</script>