<?php
$session = Config\Services::session();
helper('form');
$message = $session->getFlashdata('message');
$error = $session->getFlashdata('error');

$titleOptions = [
    'mr' => 'Mr.',
    'mrs' => 'Mrs.',
    'miss' => 'Miss.',
    'dr' => 'Dr.'
];

?>
<style>
    .card-register {
        border-radius: 1rem;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-md-6 col-lg-5 mx-auto">
            <div class="card shadow-sm card-register my-5">
                <div class="card-body">
                    <h2 class="card-title text-center"><?= getenv('app.name'); ?></h2>
                    <h5 class="card-subtitle text-center font-weight-light">Register</h5>
                    <div id="root"></div>
                    <div id="root2"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>

<script type="text/babel">
    class NameForm extends React.Component {
        constructor(props) {
            super(props);
            this.state = {firstName: ''};
            //this.state = {value: 'Write your Name'};

            this.handleEmail = this.handleSubmit.bind(this);
            this.handlePhone = this.hand
            // this.handleSubmit = this.handleSubmit.bind(this);
        }

        //TODO

        handleFirstName(event) {
            this.setState({firstName: event.target.value});
            //this.setState({value: event.target.value.toLowerCase()});
            var textval = this.state.firstName;
            //user validation of the special characters
            var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
            for (var i = 0; i < textval.length; i++) {
                if (iChars.indexOf(textval.charAt(i)) !== -1) {
                    alert("Your username should not have !@#$%^&*()+=-[]\\\';,./{}|\":<>? \nThese are not allowed.\n Please remove them and try again.");
                    //return false;
                }
            }
        }

        handleLastName(event) {
            this.setState({value2: event.target.value});
            var textval = this.state.value2;
            //user validation of the special characters
            if (isNaN(textval))
                alert(textval);
        }

        handleSubmit(event) {
            alert('The submitted name is: ' + this.state.firstName + ', Also Phone: ' + this.state.value2);
            event.preventDefault();
        }

        render() {
            return (
                //TODO: do label for=...
                <form onSubmit={this.handleSubmit} action="/client/register" method="post">
                    <div class="form-group">
                        <label for="firstName">First Name</label>
                        <input type="text" value={this.state.firstName} onChange={this.handleFirstName}
                               name="first_name" id="firstName" class="form-control" placeholder="Joe"/>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" name="last_name" id="lastName" value={this.state.lastName}
                               class="form-control"
                               placeholder="Bloggs"/>
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" value={this.state.title} class="form-control"
                               placeholder="Mr."/>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="text" name="phone" id="phoneNumber" value={this.state.phoneNumber}
                               class="form-control"
                               placeholder="01234567890"/>
                    </div>
                    <div class="form-group">
                        <label for="emailAddress">Email Address</label>
                        <input type="text" name="email" id="emailAddress" value={this.state.emailAddress}
                               class="form-control"
                               placeholder="joe.bloggs@example.com"/>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" value={this.state.password}
                               class="form-control"
                               placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <label for="passwordConfirm">Confirm Password</label>
                        <input type="password" name="password_conf" id="passwordConfirm"
                               value={this.state.passwordConfirm}
                               class="form-control" placeholder="Confirm Password"/>
                    </div>
                    <input type="submit" name="submit" value="Register Account" class="btn btn-block btn-primary"/>

                </form>
            );
        }
    }

    ReactDOM.render(
        <NameForm/>,
        document.getElementById('root')
    );


</script>

<script type="text/babel">

    class BasicForm extends React.Component {
        constructor(props) {
            super(props);
            this.state = {
                name: '',
                lastName: '',
                email: '',
                nameError: '',
                lastNameError: '',
                emailError: ''
            };
        }

        handleNameChange = event => {
            this.setState({ name: event.target.value }, () => {
                this.validateName();
            });
        };

        handleLastNameChange = event => {
            this.setState({lastName: event.target.value}, () => {
                this.validateLastName();
            });
        };


        handleEmailChange = event => {
            this.setState({ email: event.target.value }, () => {
                this.validateEmail();
            });
        };

        validateName = () => {
            const { name } = this.state;
            this.setState({
                nameError:
                    name.length > 3 ? null : 'Name must be longer than 3 characters'
            });
        }

        validateLastName = () => {
            const {lastName} = this.state;
            this.setState({
                lastNameError:
                    lastName.length > 1 ? null: 'Last name must be at least 1 character'
            });
        }

        validateEmail = () => {
            const { email } = this.state;
            this.setState({
                emailError:
                    email.length > 3 ? null : 'Email must be longer than 3 characters'
            });
        }

        handleSubmit = event => {
            event.preventDefault();
            const { name, email } = this.state;
            alert(`Your state values: \n
            name: ${name} \n
            email: ${email}`);
        };

        render() {
            return (
                <form onSubmit={this.handleSubmit}>
                    <div className='form-group'>
                        <label htmlFor='name'>Name</label>
                        <input
                            name='name'
                            className={`form-control ${this.state.nameError ? 'is-invalid' : ''}`}
                            id='name'
                            placeholder='Enter name'
                            value={this.state.name}
                            onChange={this.handleNameChange}
                            onBlur={this.validateName}
                        />
                        <div className='invalid-feedback'>{this.state.nameError}</div>
                    </div>
                    <div className='form-group'>
                        <label htmlFor='last_name'>Last Name</label>
                        <input
                                name='last_name'
                                className={`form-control ${this.state.lastNameError ? 'is-invalid' : ''}`}
                                id='last_name'
                                placeholder='Bloggs'
                                value={this.state.lastName}
                                onChange={this.handleLastNameChange}
                                onBlur={this.validateLastName}
                        />
                        <div className='invalid-feedback'>{this.state.lastNameError}</div>
                    </div>
                    <div className='form-group'>
                        <label htmlFor='email'>Email</label>
                        <input
                            name='email'
                            className={`form-control ${this.state.emailError ? 'is-invalid' : ''}`}
                            id='email'
                            placeholder='Enter email'
                            value={this.state.email}
                            onChange={this.handleEmailChange}
                            onBlur={this.validateEmail}
                        />
                        <div className='invalid-feedback'>{this.state.emailError}</div>
                    </div>
                    <button type='submit' className='btn btn-success btn-block'>
                        Submit
                    </button>
                </form>
            );
        }
    }

    ReactDOM.render(<BasicForm />, document.getElementById('root2'))


</script>