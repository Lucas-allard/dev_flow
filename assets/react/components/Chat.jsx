import React, {useEffect, useState} from 'react';
import './chat.scss'
import AddCircleIcon from '@mui/icons-material/AddCircle';
import ChatHeader from "./ChatHeader";
import ChatMessage from "./ChatMessage";
import {useSelector} from "react-redux";
import {selectChannel} from "../features/channel/channelSlice";
import {onSnapshot} from "firebase/firestore";
import {selectUser} from "../features/user/userSlice";
import {selectSearch} from "../features/search/searchSlice";
import InputEmoji from 'react-input-emoji'
import axios from "axios";
import moment from "moment/moment";
import channelMessagesAPI from "../services/channelMessagesAPI";

function Chat() {
    const [messages, setMessages] = useState([]);
    const channel = useSelector(selectChannel);
    const user = useSelector(selectUser);
    const search = useSelector(selectSearch);
    const [input, setInput] = useState("");

    const getMessages = async () => {
        if (!channel) {
            return;
        }
        onSnapshot(channelMessagesAPI.getChannelsMessages(channel.categoryId, channel.channelId), (querySnapshot) => {
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

    const searchMessages = () => messages.filter((message) =>
        message.message.includes(search.value)
        || message.fullname.includes(search.value)
    )

    const sendMessage = async () => {
        const data = {
            message: input,
            user: user,
            id: user.id,
            collection: `categoriesChannels/${channel.categoryId}/channels/${channel.channelId}/messages`
        };
        try {
            await channelMessagesAPI.addMessage(user, data)
            setInput('');

        } catch (e) {
            console.error("Error adding document: ", e);
        }
    }


    useEffect(() => {
        getMessages();
    }, [channel])

    useEffect(() => {
        if (search) {
            console.log(search)
            const searchResult = searchMessages()
            if (searchResult.length > 0) {
                setMessages(searchResult)
            }
        } else {
            getMessages()
        }
    }, [search])

    return (
        <div className="chat">
            {channel &&
                <>
                    <ChatHeader channelName={channel.channelName}/>

                    <div className="chat__messages">
                        {messages.map((message, id) =>
                            <ChatMessage
                                timestamp={message.timestamp}
                                userPicture={message.userPicture}
                                fullname={message.fullname}
                                message={message.message}
                                key={id}
                            />
                        )}
                    </div>

                    <div className="chat__input">
                        <AddCircleIcon/>

                        <form onSubmit={sendMessage}>
                            <InputEmoji
                                value={input}
                                onChange={setInput}
                                onEnter={sendMessage}
                                placeholder="Envoyer un message"
                            />
                            <input hidden={true}/>
                            <button className="chat__inputBtn" type="submit">
                                Envoyez
                            </button>
                        </form>
                    </div>
                </>
            }
        </div>
    );
}

export default Chat;