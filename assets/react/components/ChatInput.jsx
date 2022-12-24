import AddCircleIcon from "@mui/icons-material/AddCircle";
import React from "react";
import InputEmoji from 'react-input-emoji'

function ChatInput({classname, sendMessage, sendPrivateMessage, input, setInput,}) {
    return (
        <div className={classname}>
            <AddCircleIcon/>

            <form onSubmit={sendMessage ? sendMessage : sendPrivateMessage}>
                <InputEmoji
                    value={input}
                    onChange={setInput}
                    onEnter={sendMessage ? sendMessage : sendPrivateMessage}
                    placeholder="Envoyer un message"
                />
                <input hidden={true}/>
                <button className="chat__inputBtn" type="submit">
                    Envoyez
                </button>
            </form>
        </div>
    );
}

export default ChatInput;

