<template>
  <div class="chat-container" @scroll="e => e.stopPropagation()">
    <contact-nav :chats="chats" :active="chat ? chat.id: 0" @selectContact="selectContact"></contact-nav>
    <chat
      :chat="chat"
      :user-id="parseInt(userId)"
      :index="selectedChatIndex"
      @updateChatMessage="updateChatMessage"
    ></chat>
  </div>
</template>

<script>
import data from "../sample-data";

export default {
  props: ["initChats", "userId"],

  mounted() {
    this.chats = JSON.parse(this.initChats);
    this.chat = this.chats.length ? this.chats[0] : {};
    return;
  },
  methods: {
    selectContact(index) {
      const chat = this.chats[index];
      this.chat = chat;
      this.selectedChatIndex = index;
      setTimeout(() => {
        var chat_div = document.getElementsByClassName("chat-log")[0];
        if (chat_div.scrollHeight > chat_div.offsetHeight) {
          chat_div.scrollTop = chat_div.scrollHeight;
        }
      }, 0);
    },
    updateChatMessage({ index, messages, targetDiv, initScrollHeight }) {
      this.chats[index].recent_messages = this.chats[
        index
      ].recent_messages.concat(messages);

      setTimeout(() => {
        const diff = targetDiv.scrollHeight - initScrollHeight;
        targetDiv.scrollTo({
          top: diff,
          left: 0,
          behavior: "smooth"
        });
      }, 0);
    }
  },
  data() {
    return {
      chats: [],
      chat: {},
      selectedChatIndex: -1
    };
  }
};
</script>
