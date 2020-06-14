<template>
  <div class="contact-menu">
    <div
      class="contact-item"
      v-for="(chat, index) in chats"
      :key="chat.id"
      :class="chat.id===active?'contact-active':''"
      @click="() => selectContact(index)"
    >
      <div class="contact-image">
        <img :src="'https://picsum.photos/100/100?rand=' + chat.id" />
      </div>
      <div class="contact-content">
        <div class="contact-name-date">
          <span class="contact-name">{{ chat.chat_details.chat_name }}</span>
          <span
            class="contact-last-seen"
          >{{ !chat.is_grouped ? "8:40pm": chat.others[0].last_seen }}</span>
        </div>
        <div
          class="last-message"
        >{{ chat.recent_messages && chat.recent_messages.length ? chat.recent_messages[0].body : "No chat yet... " }}</div>
      </div>
    </div>

    <div v-if="!chats || !chats.length">
      <p>No chats found</p>
    </div>
  </div>
</template>

<script>
export default {
  props: ["chats", "active"],

  mounted() {},

  methods: {
    selectContact(index) {
      this.$emit("selectContact", index);
    }
  },

  data() {
    return {};
  }
};
</script>
