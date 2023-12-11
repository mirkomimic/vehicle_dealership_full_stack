<template>
  <div class="border-s-sm ps-2">
    <v-card

      min-height="100"
      rounded="lg"
      class="d-flex pa-2 me-3"
      border="sm"
    >
      <v-row>
        <v-col 
          cols="12"
          md="3"
          class="d-flex flex-row flex-md-column pb-0 pb-md-2"
        >
          <div class="d-flex">
            <div>
              <img width="30" src="/user-placeholder.png" class="rounded-circle mt-2"/>
            </div>
            <div class="ms-2 text-subtitle-2">
              <div class="text-teal-accent-2">{{ comment.user.name }}</div>
              <div class="text-grey-lighten-1">{{ moment(comment.created_at).startOf('minute').fromNow() }}</div>
            </div>
          </div>

          <div class="ms-auto ms-md-0 mt-md-auto">
            <v-btn
              v-if="comment.user_id == $page.props.auth.user.id"
              variant="text"
              color="red-lighten-3"
              density="compact"
              class="pa-0 text-decoration-underline"
            >
              Delete
            </v-btn>
          </div>
        </v-col>

        <v-divider class="my-3" vertical></v-divider>

        <v-col 
          cols="12"
          md="9"
          class="d-flex flex-column pt-0 pt-md-2"
        >
          <div class="text-grey-lighten-3" style="min-height: 50px;">
            {{ comment.comment }}
          </div>
          <div class="mt-auto d-flex align-end">
            <div>
              <v-btn
                v-if="comment.replies.length"
                @click="collapse = !collapse"
                color="teal-lighten-3"
                variant="text"
                prepend-icon="mdi-chevron-down"
                density="compact"
              >
                {{ collapse ? 'Collapse' : 'Show' }}
                <template v-slot:append>
                  ({{ comment.replies.length ? comment.replies.length : '' }})
                </template>
              </v-btn>
            </div>

            <div>
              <ReplyDialog :comment="comment"/>
            </div>

            <div class="ms-auto">
              <v-menu>
                <template v-slot:activator="{ props }">
                  <v-btn
                    icon="mdi-dots-vertical"
                    variant="text"
                    v-bind="props"
                    density="compact"
                  >
                  </v-btn>
                </template>
                <v-list density="compact" rounded="lg">
                  <v-list-item
                    v-for="(item, index) in menuItems"
                    :key="index"
                    :value="index"
                    @click="edit(comment.id)"
                    :class="item.color"
                  >
                    <template v-slot:prepend>
                      <v-icon :icon="item.icon" class="me-n4"></v-icon>
                    </template>
                    <v-list-item-title >
                      {{ item.title }}
                    </v-list-item-title>
                  </v-list-item>
                </v-list>
              </v-menu>
            </div>
          </div>
        </v-col>
      </v-row>
    </v-card>

    <div class="ms-2 mt-3">
      <Comments
        v-if="collapse"
        v-for="reply in comment.replies"
        :key="reply"
        :comment="reply" 
      />
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ReplyDialog from '../Dialogs/ReplyDialog.vue';
import moment from "moment";

const props = defineProps(['comment'])

const collapse = ref(true)

const menuItems = [
  {
    icon: 'mdi-pencil-box-outline',
    title: 'Edit',
    color: 'text-teal-accent-1',
  },
  {
    icon: 'mdi-exclamation-thick',
    title: 'Report',
    color: 'text-yellow-darken-2',
  }
]

const edit = (id) => {
  console.log(id);
}
</script>