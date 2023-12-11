<template>
  <!-- <v-row > -->
    <v-dialog
      v-model="dialog"
      width="1024"
    >
      <template v-slot:activator="{ props }">
        <v-btn
          v-bind="props"
          color="teal-accent-2"
          variant="outlined"
          density="compact"
          prepend-icon="mdi-comment-outline"
        >
          Reply
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="text-h5 text-teal-lighten-4">Reply</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12"
              >
                <v-textarea
                  v-model="form.reply"
                  label="Reply"
                  variant="outlined"
                  color="teal-lighten-3"
                ></v-textarea>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="teal-lighten-3"
            variant="text"
            @click="close"
          >
            Close
          </v-btn>
          <v-btn
            color="teal-lighten-3"
            variant="text"
            @click="submit"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  <!-- </v-row> -->
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { watch } from 'vue';
import { ref } from 'vue';

const props = defineProps(['comment'])

const dialog = ref(false)

const form = useForm({
  parent_id: props.comment.id,
  vehicle_id: props.comment.vehicle_id,
  reply: '',
})

const submit = () => {
  form.post(route('comment.reply'), {
    preserveScroll: true,
  })
  form.reset()
  dialog.value = false
}

const close = () => {
  form.reset()
  dialog.value = false
}

watch(dialog, () => {
  dialog.value || form.reset()
})
</script>