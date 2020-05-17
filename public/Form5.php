<!DOCTYPE html>
<html lang="en">

<title>Demostration of Forms in React</title>
<script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
<body>

<h1> Demostration of Forms in React</h1>
<div id="root"></div>

<!--<script type="text/babel">-->
<!--    import React from 'react';-->
<!--    import ReactDOM from "react-dom";-->
<!--    import {useForm} from 'react-hook-form';-->
<!---->
<!--    class NameForm extends React.Component {-->
<!--        constructor(props) {-->
<!--            super(props);-->
<!--        }-->
<!---->
<!---->
<!--        render() {-->
<!--            const {register, handleSubmit, errors} = useForm();-->
<!--            const onSubmit = data => console.log(data);-->
<!--            console.log(errors);-->
<!---->
<!--            return (-->
<!--                <form onSubmit={handleSubmit(onSubmit)}>-->
<!--                    <label>-->
<!--                        <input type="text" placeholder="First name" name="first_name"-->
<!--                               ref={register({required: true, maxLength: 255})}/>-->
<!--                    </label>-->
<!--                    <input type="text" placeholder="Last name" name="last_name"-->
<!--                           ref={register({required: true, maxLength: 255})}/>-->
<!--                    <select name="Title" ref={register({required: true})}>-->
<!--                        <option value="Mr">Mr</option>-->
<!--                        <option value="Mrs">Mrs</option>-->
<!--                        <option value="Miss">Miss</option>-->
<!--                        <option value="Dr">Dr</option>-->
<!--                    </select>-->
<!--                    <input type="tel" placeholder="0123456789" name="Mobile number"-->
<!--                           ref={register({required: true, minLength: 6, maxLength: 12})}/>-->
<!--                    <input type="email" placeholder="joe.bloggs@example.com" name="Email" ref={register({-->
<!--                        required: true,-->
<!--                        pattern: /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/i-->
<!--                    })}/>-->
<!--                    <input type="password" placeholder="Password" name="password"-->
<!--                           ref={register({required: true, min: 8})}/>-->
<!--                    <input type="password" placeholder="Confirm Password" name="Confirm Password"-->
<!--                           ref={register({required: true, min: 8})}/>-->
<!---->
<!--                    <input type="submit"/>-->
<!--                </form>-->
<!--            );-->
<!--        }-->
<!--    }-->
<!---->
<!--    ReactDOM.render(-->
<!--        <NameForm/>,-->
<!--        document.getElementById('root')-->
<!--    );-->
<!---->
<!---->
<!--</script>-->
<!---->
<!--<script type="text/babel">-->
<!--    import React from 'react';-->
<!--    import ReactDOM from "react-dom";-->
<!--    import {useForm} from 'react-hook-form';-->
<!---->
<!--    function App() {-->
<!--        const {register, handleSubmit, errors} = useForm();-->
<!--        const onSubmit = data => console.log(data);-->
<!--        console.log(errors);-->
<!---->
<!--        return (-->
<!--            <form onSubmit={handleSubmit(onSubmit)}>-->
<!--                <label>-->
<!--                    <input type="text" placeholder="First name" name="first_name"-->
<!--                           ref={register({required: true, maxLength: 255})}/>-->
<!--                </label>-->
<!--                <input type="text" placeholder="Last name" name="last_name"-->
<!--                       ref={register({required: true, maxLength: 255})}/>-->
<!--                <select name="Title" ref={register({required: true})}>-->
<!--                    <option value="Mr">Mr</option>-->
<!--                    <option value="Mrs">Mrs</option>-->
<!--                    <option value="Miss">Miss</option>-->
<!--                    <option value="Dr">Dr</option>-->
<!--                </select>-->
<!--                <input type="tel" placeholder="0123456789" name="Mobile number"-->
<!--                       ref={register({required: true, minLength: 6, maxLength: 12})}/>-->
<!--                <input type="email" placeholder="joe.bloggs@example.com" name="Email" ref={register({-->
<!--                    required: true,-->
<!--                    pattern: /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/i-->
<!--                })}/>-->
<!--                <input type="password" placeholder="Password" name="password"-->
<!--                       ref={register({required: true, min: 8})}/>-->
<!--                <input type="password" placeholder="Confirm Password" name="Confirm Password"-->
<!--                       ref={register({required: true, min: 8})}/>-->
<!---->
<!--                <input type="submit"/>-->
<!--            </form>-->
<!--        );-->
<!--    }-->
<!---->
<!---->
<!--    ReactDOM.render(-->
<!--        <App/>, document.getElementById("register_form"));-->
<!---->
<!--</script>-->
<!---->
<!--<div id="root"></div>-->
<!--<script type="text/babel">-->
<!--    import React from "react";-->
<!--    import ReactDOM from "react-dom";-->
<!--    import {useForm} from "react-hook-form";-->
<!---->
<!--    import "./index.css";-->
<!---->
<!--    function App() {-->
<!--        const {register, handleSubmit} = useForm();-->
<!--        const onSubmit = data => {-->
<!--            alert(JSON.stringify(data));-->
<!--        };-->
<!---->
<!--        return (-->
<!--            <div className="App">-->
<!--                <form onSubmit={handleSubmit(onSubmit)}>-->
<!--                    <div>-->
<!--                        <label htmlFor="firstName">First Name</label>-->
<!--                        <input name="firstName" placeholder="bill" ref={register}/>-->
<!--                    </div>-->
<!---->
<!--                    <div>-->
<!--                        <label htmlFor="lastName">Last Name</label>-->
<!--                        <input name="lastName" placeholder="luo" ref={register}/>-->
<!--                    </div>-->
<!---->
<!--                    <div>-->
<!--                        <label htmlFor="isDeveloper">Is an developer?</label>-->
<!--                        <input-->
<!--                            type="checkbox"-->
<!--                            name="isDeveloper"-->
<!--                            placeholder="luo"-->
<!--                            value="yes"-->
<!--                            ref={register}-->
<!--                        />-->
<!--                    </div>-->
<!---->
<!--                    <div>-->
<!--                        <label htmlFor="email">Email</label>-->
<!--                        <input-->
<!--                            name="email"-->
<!--                            placeholder="bluebill1049@hotmail.com"-->
<!--                            type="email"-->
<!--                            ref={register}-->
<!--                        />-->
<!--                    </div>-->
<!--                    <input type="submit"/>-->
<!--                </form>-->
<!--            </div>-->
<!--        );-->
<!--    }-->
<!---->
<!--    const rootElement = document.getElementById("root");-->
<!--    ReactDOM.render(<App/>, rootElement);-->
<!---->
<!--</script>-->
<!---->

<div id="test"></div>

<script type="text/babel">
    import React from 'react';
    import ReactDOM from 'react-dom';

    class MyForm extends React.Component {
        render() {
            return (
                <form>
                    <h1>Hello</h1>
                    <p>Enter your name:</p>
                    <label>
                        <input type="text"/>
                    </label>
                </form>
            );
        }
    }

    ReactDOM.render(<MyForm/>, document.getElementById('test'));

</script>

</body>
</html>