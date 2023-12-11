<template>
  <Head title="Vehicle"/>
  <MainLayout>

    <v-overlay v-model="galleryOverlay" class="d-none d-md-flex items-center justify-center">
      <FullScreenVueCarouselGallery :vehicle="vehicle"/>
    </v-overlay>

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
                <td>{{ vehicle.price }}</td>
              </tr>
              <tr>
                <td>Created</td>
                <td>{{ new Date(vehicle.created_at).toLocaleDateString() }}</td>
              </tr>
            </tbody>
          </v-table>
        </v-col>
      </v-row>

      <v-divider class="mt-10 mb-5"></v-divider>

      <div class="text-h4 text-teal-darken-3 mb-5">Comments</div>
      <!-- bg-color="amber-lighten-4" -->
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

      <div class="mt-3" style="height: 1000px; overflow: scroll;">
        <Comments
          v-for="comment in comments"
          :key="comment"
          :comment="comment" 
        />
      </div>

    </v-container>
  </MainLayout>
</template>

<script setup>
import Comments from '@/Components/Comments/Comments.vue';
import FullScreenVueCarouselGallery from '@/Components/Gallery/FullScreenVueCarouselGallery.vue';
import VueCarouselGallery from '@/Components/Gallery/VueCarouselGallery.vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps(['vehicle', 'comments'])

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
</script>