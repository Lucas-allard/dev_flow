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

function Chat() {
    const [messages, setMessages] = useState([]);
    const channel = useSelector(selectChannel)
    const user = useSelector(selectUser)
    const [input, setInput] = useState("")

    const getMessage = async () => {

        if (!channel) {
            return
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
                            id: doc.id,
                            timestamp: moment(doc.data().timestamp.toDate().toUTCString()).locale("fr").format('ll'),
                            userPicture: doc.data().user.profilPicture,
                            fullname: doc.data().user.fullname,
                            message: doc.data().content,
                        }
                    ]
                )
            });
        });
    }

    useEffect(() => {
        getMessage();
    }, [channel])

    useEffect(() => {
        console.log(messages);
    }, [messages])

    const sendMessage = async () => {
        console.log(input)
        try {
            const docRef = await addDoc(collection(db, `categoriesChannels/${channel.categoryId}/channels/${channel.channelId}/messages`), {
                timestamp: new Date(),
                content: input,
                user: user
            })

            setInput('');

            console.log("Document written with ID: ", docRef.id);
        } catch (e) {
            console.error("Error adding document: ", e);
        }
    }

    return (
        <div className="chat">
            {channel &&
                <>
                    <ChatHeader channelName={channel.channelName}/>

                    <div className="chat__messages">
                        {messages.map(message =>
                            <ChatMessage
                                timestamp={message.timestamp}
                                userPicture={message.userPicture}
                                fullname={message.fullname}
                                message={message.message}
                                key={message.id}
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