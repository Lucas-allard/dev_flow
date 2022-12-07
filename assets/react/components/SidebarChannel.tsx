import React, {FunctionComponent} from 'react';
import './sidebarChannel.scss'

type Props = {
    channel: string
}

const SidebarChannel: FunctionComponent<Props> = ({channel}) => {
    return (
        <div className="sidebarChannel">
            <h4>
                <span className="sidebarChannel__hash">#</span>{channel}
            </h4>
        </div>
    );
}

export default SidebarChannel;