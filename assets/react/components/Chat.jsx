import React from 'react';
import './chat.scss'
import ChatHeader from "./ChatHeader";
import AddCircleIcon from '@mui/icons-material/AddCircle';
import CardGiftcardIcon from '@mui/icons-material/CardGiftcard';
import GifIcon from '@mui/icons-material/Gif';
import EmojiEmotionsIcon from '@mui/icons-material/EmojiEmotions';
import ChatMessage from "./ChatMessage";

function Chat() {
    return (
        <div className="chat">
            <ChatHeader/>

            <div className="chat__messages">
                <ChatMessage/>
            </div>

            <div className="chat__input">
                <AddCircleIcon/>

                <form action="">
                    <input placeholder="Envoyer un message" type="text"/>
                    <button className="chat__inputBtn" type="submit">
                        Envoyez
                    </button>
                </form>

                <div className="chat__inputIcon">
                    <CardGiftcardIcon/>
                    <GifIcon/>
                    <EmojiEmotionsIcon/>
                </div>
            </div>
        </div>
    );
}

export default Chat;