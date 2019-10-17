<template>
    <div id="frame" v-if="user">
        <div id="sidepanel">
            <div id="profile">
                <div class="wrap">
                    <img id="profile-img" :src="user.avatar" class="online" alt=""/>
                    <p>{{user.name}}</p>
                </div>
            </div>
            <div id="contacts">
                <ul>
                    <li v-for="chat in chats" :class="{active:activeChatId===chat.id,'contact':true}"
                        @click="selectChat(chat)">
                        <div class="wrap">
                            <img src="https://image.flaticon.com/icons/svg/2111/2111614.svg"
                                 alt=""/>
                            <div class="meta">
                                <p class="name">{{chat.name}}</p>
                                <p class="preview">{{chat.last_message}}</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content" v-if="activeChat">
            <div class="contact-profile">
                <img src="https://image.flaticon.com/icons/svg/2111/2111614.svg"
                     alt=""/>
                <p>{{activeChat.name}}</p>
            </div>
            <div ref="chatContainer" class="messages">
                <ul>

                    <li v-if="activeChat.messages.length==0" class="no-chats text-center">
                        <p>No chats yet</p>
                    </li>
                    <li v-for="message in activeChat.messages"
                        :class="{'replies':message.author.id===user.id,'sent':message.author.id!==user.id}"
                        :title="message.author.name">
                        <img :src="message.author.avatar"/>
                        <p>{{message.message}}</p>
                    </li>
                </ul>
            </div>
            <div class="message-input">
                <div class="wrap">
                    <form
                            @submit="sendChat"
                    >
                        <input v-model="message" type="text" placeholder="Write your message..."/>
                        <button type="submit" class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i>
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {v1 as uuid} from 'uuid';
    export default {
        props: ['user', 'browserIdentity'],
        data() {
            return {
                message: '',
                sending: false,
                workspaceId: 1,
                activeChatId: '',
                chats: [
                    {
                        id: 'general',
                        name: 'General',
                        messages: [],
                        last_message: ''
                    },
                    {id: 'chat-1', name: 'My First Chat Group', messages: [], last_message: ''},
                    {id: 'chat-2', name: 'My Second Chat Group', messages: [], last_message: ''},
                ]
            }
        },
        computed: {
            activeChat: function () {
                return _.find(this.chats, {'id': this.activeChatId})
            }
        },
        mounted() {
            console.log('browserIdentity user:', this.browserIdentity);
            console.log('Chat user:', this.user);
            setTimeout(() => {
                this.listenGeneralPrivateChannel();
                this.listenUserPrivateChannel();
                this.listenUserWorkspacePrivateChannel()
            }, 1000);

            this.selectChat(this.chats[0])
        },
        methods: {
            sendChat(e) {
                e.preventDefault();

                const message = this.message

                if (message.trim().length===0) return false

                const user = this.user
                const browserIdentity = this.browserIdentity
                const activeChatId = this.activeChatId


                const client_chat_message = {
                    browser_identity: browserIdentity,
                    message: {
                        id: uuid(),
                        message: message,
                        author: {
                            id: user.id,
                            name: user.name,
                            email: user.email,
                            avatar: user.avatar
                        }
                    },
                    chat_id: activeChatId
                };
                this.appendChatMessage(client_chat_message)

                this.message = '';

                axios.post('/send-chat', {
                    message: message,
                    chat_id: activeChatId,
                    author_id: user.id,
                    browser_identity: browserIdentity,
                })
                    .then((response) => {
                        if (response.status === 200) {
                            const data = response.data;

                        }

                    })
                    .catch((error) => {
                    });
            },
            appendChatMessage(data) {
                let chat = _.find(this.chats, {'id': data.chat_id});
                chat.last_message = data.message.message;
                chat.messages.push(data.message);

                setTimeout(()=>{
                    const chatContainer = this.$refs.chatContainer;
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                },300)

            },
            selectChat(chat) {
                this.activeChatId = chat.id
            },
            listenGeneralPrivateChannel() {
                //TODO:this need to change to private channel at the time of implementation
                Echo.channel(`general-channel`)
                    .listen('global-announcement', (data) => {
                        console.log('global-announcement', data)
                    })
            },
            listenUserPrivateChannel() {
                //TODO:this need to change to private channel at the time of implementation
                Echo.channel(`workspace-${this.workspaceId}-user-${this.user.id}`)
                    .listen('.new.chat', (data) => {
                        console.log('chat signal :', data);
                        if (this.browserIdentity !== data.browser_identity) {
                            this.appendChatMessage(data)
                        }
                    })
            },
            listenUserWorkspacePrivateChannel() {
                //TODO:this need to change to private channel at the time of implementation
                Echo.channel(`workspace-${this.workspaceId}`)
                    .listen('workspace-announcement', (data) => {

                        console.log('workspace-announcement', data)
                    })
            },
        }
    }
</script>
