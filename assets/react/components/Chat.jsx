import React, {useEffect, useState} from 'react';
import './chat.scss'
import ChatHeader from "./ChatHeader";
import AddCircleIcon from '@mui/icons-material/AddCircle';
import CardGiftcardIcon from '@mui/icons-material/CardGiftcard';
import GifIcon from '@mui/icons-material/Gif';
import EmojiEmotionsIcon from '@mui/icons-material/EmojiEmotions';
import ChatMessage from "./ChatMessage";
import {useSelector} from "react-redux";
import {selectChannel} from "../features/channel/channelSlice";
import {addDoc, collection, onSnapshot, orderBy, query} from "firebase/firestore";
import {db} from "../../firebase";
import {selectUser} from "../features/user/userSlice";
import moment from "moment/moment";
import InputEmoji from 'react-input-emoji'
import {selectSearch} from "../features/search/searchSlice";
import axios from "axios";

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

        const q = query(
            collection(db, `categoriesChannels/${channel.categoryId}/channels/${channel.channelId}/messages`),
            orderBy("timestamp", "asc")
        );
        onSnapshot(q, (querySnapshot) => {
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
            axios.defaults["x-csrf-token"] = user.csrfToken;
            const options = {
                method: 'POST',
                headers: {
                    'content-type': 'application/json',
                },
                data: JSON.stringify(data),
                url: "https://localhost:8000/chat/send",
            };
            // const docRef = await addDoc(collection(db, `categoriesChannels/${channel.categoryId}/channels/${channel.channelId}/messages`), message);
            const symRef = await axios(options);
            console.log(symRef)
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
            const searchResult = searchMessages()
            if (searchResult.length > 0) {
                setMessages(searchResult)
            }
        } else {
            getMessages()
        }
    }, [search])

    useEffect(() => {
        console.log(user)
    }, [user])

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