<template>
  <div class="chat-session">
    <div class="chat-log" @scroll="handleScroll">
      <div class="d-flex justify-content-center mb-2" v-if="loading">
        <div class="bg-light p-1 rounded-circle shadow text-info">
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
      </div>
      <div
        class="chat-item"
        v-for="(message, i) in orderedMessages"
        :key="message.id"
        :class="{'is-user-post': message.user_id === userId}"
      >
        <div
          class="chat-content shadow-sm"
          :class="{'is-end-speech': !(orderedMessages[i+1] && ( message.user_id === userId)  === (orderedMessages[i+1].user_id === userId))}"
        >
          <div class="chat-message">{{ message.body }}</div>
          <div class="chat-time">{{ message.created_at | time }}</div>
        </div>
      </div>
    </div>
    <div class="chat-input">
      <input type="text" class="form-control" />
      <span class="attachment">
        <i class="fa fa-paperclip" aria-hidden="true"></i>
      </span>
      <span class="send">
        <i class="fa fa-paper-plane" aria-hidden="true"></i>
      </span>
    </div>
  </div>
</template>

<script>
const RECORD_PER_PAGE = 10.0;
export default {
  props: ["chat", "userId", "index"],

  mounted() {
    this.page =
      this.chat && this.chat.recent_messages
        ? Math.ceil(this.chat.recent_messages.length / RECORD_PER_PAGE)
        : 1;
  },

  watch: {
    chat: function(chat, prevChat) {
      if (chat && prevChat && prevChat.id != chat.id) {
        this.page =
          chat && chat.recent_messages
            ? Math.ceil(chat.recent_messages.length / RECORD_PER_PAGE)
            : 1;
        this.false = false;
        this.isEnd = false;
        this.loading = false;
      }
    }
  },

  data() {
    return {
      loading: false,
      isEnd: false,
      page: 1
    };
  },

  methods: {
    handleScroll(e) {
      if (
        e.target.scrollTop < 50 &&
        !this.loading &&
        !this.isEnd &&
        e.target.scrollHeight > e.target.offsetHeight
      ) {
        const initScrollHeight = e.target.scrollHeight;
        const index = this.index;
        this.loading = true;
        axios
          .get(
            `http://localhost:8000/api/messages/${this.chat.id}?page=${this
              .page + 1}`
          )
          .then(response => {
            const messages = response.data.messages;
            this.$emit("updateChatMessage", {
              index: index,
              messages: response.data.messages.data,
              targetDiv: e.target,
              initScrollHeight
            });
            this.page += 1;
            this.isEnd = messages.last_page <= messages.current_page;
            setTimeout(() => (this.loading = false), 100);
          })
          .catch(e => {
            console.log(e);
            this.loading = false;
          });
      }
    }
  },

  filters: {
    time: function(value) {
      return dayjs(value).format("HH:MM a");
    }
  },

  computed: {
    orderedMessages: function() {
      return this.chat && this.chat.recent_messages
        ? this.chat.recent_messages.slice().reverse()
        : [];
    }
  }
};
</script>
