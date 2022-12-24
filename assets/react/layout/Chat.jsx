import React, {useEffect, useMemo, useState} from 'react';
import './chat.scss'
import ChatHeader from "../components/ChatHeader";
import ChatMessage from "../components/ChatMessage";
import {useSelector} from "react-redux";
import {selectChannel, setChannel} from "../features/channel/channelSlice";
import {onSnapshot} from "firebase/firestore";
import {selectUser, selectUserProfil} from "../features/user/userSlice";
import {selectSearch} from "../features/search/searchSlice";
import moment from "moment/moment";
import channelMessagesAPI from "../services/channelMessagesAPI";
import ChatInput from "../components/ChatInput";
import privatesMessagesChannelsAPI from "../services/privatesMessagesChannelsAPI";

function Chat() {
    const [messages, setMessages] = useState([]);
    const [privatesMessages, setPrivatesMessages] = useState([]);
    const channel = useSelector(selectChannel);
    const user = useSelector(selectUser);
    const search = useSelector(selectSearch);
    const [input, setInput] = useState("");

    useEffect(() => {
        setPrivatesMessages(null)
        getMessages();
    }, [channel?.categoryId])

    useEffect(() => {
        setMessages(null);
        getPrivatesMessages();
    }, [channel?.sender])

    const getMessages = async () => {
        if (!channel?.categoryId) {
            return;
        }
        onSnapshot(channelMessagesAPI.getChannelsMessages(channel.categoryId, channel.id), (querySnapshot) => {
            setMessages([]);
            querySnapshot.forEach((doc) => {
                setMessages(
                    (message) => [
                        ...message,
                        {
                            timestamp: moment(doc.data().timestamp.toDate().toUTCString()).locale("fr").format('ll'),
                            userPicture: doc.data().profilPicture,
                            fullname: doc.data().fullname,
                            message: doc.data().message,
                        }
                    ]
                )
            });
        });
    }

    const getPrivatesMessages = async () => {
        if (!channel?.sender) {
            return;
        }
        onSnapshot(privatesMessagesChannelsAPI.getPrivatesMessages(user.fullname, channel.sender), (querySnapshot) => {
            setPrivatesMessages([]);
            const uniqueMessages = new Set();
            querySnapshot.forEach((doc) => {
                if (!uniqueMessages.has(doc.data().message)) {
                    uniqueMessages.add(doc.data().message);
                    setPrivatesMessages(
                        (message) => [
                            ...message,
                            {
                                timestamp: moment(doc.data().timestamp.toDate().toUTCString()).locale("fr").format("LLL"),
                                from: doc.data().from,
                                to: doc.data().to,
                                message: doc.data().message,
                            }
                        ]
                    )
                }
            });
        });
    }

    const sendMessage = async () => {
        const data = {
            message: input,
            user: user,
            id: user.id,
            collection: `categoriesChannels/${channel.categoryId}/channels/${channel.id}/messages`
        };
        try {
            await channelMessagesAPI.addMessage(user, data)
            setInput('');

        } catch (e) {
            console.error("Error adding document: ", e);
        }
    }

    const sendPrivateMessage = async () => {
        const data = {
            from: user.fullname,
            to: channel.sender,
            participants: [user.fullname, channel.sender],
            message: input,
            user: user,
            collection: "privatesMessages"
        };
        try {
            const {status} = await privatesMessagesChannelsAPI.addMessage(user, data)
            if (status === 201) {
                setInput('');
            }
        } catch (e) {
            console.error("Error adding document: ", e);
        }
    }

    const searchResult = useMemo(() => {
        if (messages && search) return messages.filter((message) =>
            message.message.includes(search.value) || message.fullname.includes(search.value)
        );
    }, [messages, search]);

    const searchPrivateResult = useMemo(() => {
        if (privatesMessages && search) return privatesMessages.filter((message) => message.message.includes(search.value));
    }, [privatesMessages, search]);

    useEffect(() => {
        if (search) {
            if (searchResult) {
                setMessages(searchResult);
            } else if (searchPrivateResult) {
                setPrivatesMessages(searchPrivateResult);
            }
        } else {
            getMessages();
            getPrivatesMessages();
        }
    }, [search]);

    return (
        <div className="chat">
            {channel &&
                <>
                    <ChatHeader channelName={channel.name || channel.sender}/>

                    <div className="chat__messages">
                        {messages && messages.map((message, id) =>
                            <ChatMessage
                                timestamp={message.timestamp}
                                userPicture={message.userPicture}
                                fullname={message.fullname}
                                message={message.message}
                                key={id}
                            />
                        )}
                        {privatesMessages && privatesMessages.map((message, id) =>
                            <ChatMessage
                                timestamp={message.timestamp}
                                fullname={message.from}
                                message={message.message}
                                key={id}
                            />
                        )}
                    </div>

                    {messages &&
                        <ChatInput
                            classname="chat__input"
                            sendMessage={sendMessage}
                            input={input}
                            setInput={setInput}
                        />
                    }

                    {privatesMessages &&
                        <ChatInput
                            classname="chat__input"
                            sendPrivateMessage={sendPrivateMessage}
                            input={input}
                            setInput={setInput}
                        />
                    }

                </>
            }
        </div>
    );
}

export default Chat;