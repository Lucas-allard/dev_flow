import AddCircleIcon from "@mui/icons-material/AddCircle";
import EmojiEmotionsIcon from '@mui/icons-material/EmojiEmotions';
import GifIcon from '@mui/icons-material/Gif';
import React, {useEffect, useRef, useState} from "react";
import EmojiPicker from 'emoji-picker-react';
import GifPicker from 'gif-picker-react';
import {TENOR_API_KEY} from "../config/tenorApiKey";


function ChatInput({classname, sendMessage, sendPrivateMessage, input, setInput,}) {
    const textareaRef = useRef(null);
    const [isActiveEmojiPicker, setIsActiveEmojiPicker] = useState(false)
    const [isActiveGifPicker, setIsActiveGifPicker] = useState(false)

    const handleEmojiClick = (event) => {
        let sym = event.unified.split("-");
        let codesArray = [];
        sym.forEach((el) => codesArray.push("0x" + el));
        let emoji = String.fromCodePoint(...codesArray);
        setInput(input + emoji);
        textareaRef.current.innerHTML += emoji
    };

    const handleGifSelect = (gif) => {
        console.log(gif.url)
        const image = new Image();
        image.src = gif.url;
        setInput(input + image.outerHTML)
        textareaRef.current.innerHTML += image.outerHTML;
    };

    function handleKeyPress(event) {
        if (event.key === 'Enter' && event.shiftKey) {
            event.preventDefault();
            setInput(input + '\n');
            event.currentTarget.innerHTML += '<br>';
            moveCursorToEnd()
        } else if (event.key === 'Enter') {
            sendMessage ? sendMessage(event) : sendPrivateMessage(event)
            event.currentTarget.innerHTML = "";
        }
    }

    function moveCursorToEnd() {
        const range = document.createRange();
        const selection = window.getSelection();
        range.selectNodeContents(textareaRef.current);
        range.collapse(false);
        selection.removeAllRanges();
        selection.addRange(range);
    }

    return (
        <>
            <div className={classname} style={{position: "relative"}}>
                <AddCircleIcon/>
                <form onSubmit={sendMessage ? sendMessage : sendPrivateMessage}>
                    <div
                        ref={textareaRef}
                        onKeyDown={handleKeyPress}
                        contentEditable={true}
                        onInput={(e) => setInput(e.currentTarget.innerHTML)}
                        placeholder="Envoyer un message"
                    />
                    <input hidden={true}/>
                    <button className="chat__inputBtn" type="submit">
                        Envoyez
                    </button>

                </form>
                <EmojiEmotionsIcon onClick={() => setIsActiveEmojiPicker(!isActiveEmojiPicker)}/>
                <GifIcon onClick={() => setIsActiveGifPicker(!isActiveGifPicker)}/>
                {isActiveEmojiPicker &&
                    <div className="chat__inputEmoji">
                        <EmojiPicker onEmojiClick={handleEmojiClick}/>
                    </div>
                }
                {isActiveGifPicker &&
                    <div className="chat__inputGif">
                        <GifPicker
                            tenorApiKey={TENOR_API_KEY}
                            country="FR"
                            locale="fr_FR"
                            onGifClick={handleGifSelect}
                        />
                    </div>
                }

            </div>

        </>

    );
}

export default ChatInput;

