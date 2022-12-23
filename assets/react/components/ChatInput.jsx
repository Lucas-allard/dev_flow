import AddCircleIcon from "@mui/icons-material/AddCircle";
import React from "react";
import InputEmoji from 'react-input-emoji'

function ChatInput({classname, sendMessage, input, setInput,}) {
    return (
        <div className={classname}>
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
    );
}

export default ChatInput;

