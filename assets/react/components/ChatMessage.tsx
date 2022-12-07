import React, {FunctionComponent} from 'react';
import "./chatMessage.scss"
import Avatar from '@mui/material/Avatar';

type Props = {}

const ChatMessage: FunctionComponent<Props> = (props) => {
    return (
        <div className="message">
            <Avatar/>

            <div className="message__info">
                <h4>
                    People Name
                    <span className="message__timestamp">Timestamp</span>
                </h4>
                <p>message</p>
            </div>
        </div>
    );
}

export default ChatMessage;