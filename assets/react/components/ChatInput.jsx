import React, {useEffect, useRef, useState} from 'react';
import {useSelector} from 'react-redux';
import EmojiPicker from 'emoji-picker-react';
import GifPicker from 'gif-picker-react';
import {selectUsers} from '../features/user/userSlice';

import {TENOR_API_KEY} from '../config/tenorApiKey';
import AddCircleIcon from '@mui/icons-material/AddCircle';
import EmojiEmotionsIcon from '@mui/icons-material/EmojiEmotions';
import GifIcon from '@mui/icons-material/Gif';

const ChatInput = ({
                       classname,
                       sendMessage,
                       sendPrivateMessage,
                       input,
                       setInput,
                   }) => {
    const textareaRef = useRef(null);
    const [isActiveEmojiPicker, setIsActiveEmojiPicker] = useState(false);
    const [isActiveGifPicker, setIsActiveGifPicker] = useState(false);
    const [isMentioning, setIsMentioning] = useState(false);
    const [mentionQuery, setMentionQuery] = useState('');
    const [suggestions, setSuggestions] = useState([]);
    const users = useSelector(selectUsers);


    const handleEmojiClick = (event) => {
        const sym = event.unified.split('-');
        const codesArray = sym.map((el) => `0x${el}`);
        const emoji = String.fromCodePoint(...codesArray);

        setInput(input + emoji);
        textareaRef.current.innerHTML += emoji;
    };

    const handleGifSelect = (gif) => {
        const image = new Image();
        image.src = gif.url;

        setInput(input + image.outerHTML);
        textareaRef.current.innerHTML += image.outerHTML;
    };

    const handleKeyDown = (event) => {
        const {key} = event;
        if (key === 'Enter' && event.shiftKey) {
            event.preventDefault();
            setInput(input + '\n');
            event.currentTarget.innerHTML += '<br>';
            moveCursorToEnd();
        } else if (key === 'Enter') {
            // Envoyer le message et vider le champ de saisie si on appuie sur "Entrée"
            sendMessage ? sendMessage(event) : sendPrivateMessage(event);
            event.currentTarget.innerHTML = '';
        } else if (key === 'Backspace') {
            setIsMentioning(false);
            setMentionQuery('');
            setSuggestions([]);
        }
    };

    const moveCursorToEnd = () => {
        const range = document.createRange();
        const selection = window.getSelection();
        range.selectNodeContents(textareaRef.current);
        range.collapse(false);
        selection.removeAllRanges();
        selection.addRange(range);
    }

    const handleInputChange = (event) => {
        const value = event.currentTarget.innerHTML;
        setInput(value);


        // Détecter si l'utilisateur a saisi le caractère "@"
        if (value.endsWith('@')) {
            setIsMentioning(true);
            setMentionQuery('');
            setSuggestions(users);
        } else if ((isMentioning && value.endsWith(' '))) {
            // Si l'utilisateur a saisi un espace, cela signifie qu'il a fini de saisir la mention
            setIsMentioning(false);
            setMentionQuery('');
            setSuggestions([]);
        } else if (isMentioning) {
            // Si l'utilisateur est en train de saisir une mention, mettre à jour la liste de suggestions en filtrant les utilisateurs en fonction de la chaîne de caractères qu'il a saisie
            setMentionQuery(value.slice(value.lastIndexOf('@') + 1));
            setSuggestions(
                users.filter((user) => user.fullname.toLowerCase().includes(mentionQuery.toLowerCase())),
            );
        }
    }

    const handleSuggestionClick = (name, event) => {

        setInput(input.slice(0, input.lastIndexOf('@')) + `@${name} `);
        textareaRef.current.innerHTML = textareaRef.current.innerHTML.slice(0, textareaRef.current.innerHTML.lastIndexOf('@')) + `@${name} `
        setIsMentioning(false);
        setMentionQuery('');
        setSuggestions([]);
    }

    useEffect(() => {
        console.log(users);
    }, [users]);

    return (
        <>
            <div className={classname} style={{position: 'relative'}}>
                <AddCircleIcon/>
                <form onSubmit={sendMessage ? sendMessage : sendPrivateMessage}>
                    <div
                        ref={textareaRef}
                        onKeyDown={handleKeyDown}
                        contentEditable
                        onInput={handleInputChange}
                        placeholder="Envoyer un message"
                    />
                    {suggestions.length > 0 && (
                        <ul className="chat__inputMentionsList">
                            {suggestions.map((suggestion) => (

                                <li
                                    key={suggestion.id}
                                    onClick={() => handleSuggestionClick(suggestion.fullname)}
                                >
                                    {suggestion.fullname}
                                </li>
                            ))}
                        </ul>
                    )}
                    <button className="chat__inputBtn" type="submit">
                        Envoyez
                    </button>
                </form>
                <EmojiEmotionsIcon onClick={() => setIsActiveEmojiPicker(!isActiveEmojiPicker)}/>
                <GifIcon onClick={() => setIsActiveGifPicker(!isActiveGifPicker)}/>
                {isActiveEmojiPicker && (
                    <div className="chat__inputEmoji">
                        <EmojiPicker onEmojiClick={handleEmojiClick}/>
                    </div>
                )}
                {isActiveGifPicker && (
                    <div className="chat__inputGif">
                        <GifPicker
                            tenorApiKey={TENOR_API_KEY}
                            country="FR"
                            locale="fr_FR"
                            onGifClick={handleGifSelect}
                        />
                    </div>
                )}
            </div>
        </>
    );
}

export default ChatInput
