## first row

#### Code

```php
use Partitech\PhpMistral\Clients\HuggingFace\HuggingFaceDatasetClient;
use Partitech\PhpMistral\MistralClientException;

$apiKey = getenv('HF_TOKEN');

$client = new HuggingFaceDatasetClient (apiKey: (string) $apiKey);

try {
    $firstRows = $client->firstRows(
        dataset: 'ibm-research/duorc',
        split: 'train',
        config: 'SelfRC'
    );
    print_r($firstRows);
} catch (MistralClientException $e) {
    print_r($e->getMessage());
}
```


#### Result

```text
Array
(
    [dataset] => ibm-research/duorc
    [config] => SelfRC
    [split] => train
    [features] => Array
        (
            [0] => Array
                (
                    [feature_idx] => 0
                    [name] => plot_id
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [1] => Array
                (
                    [feature_idx] => 1
                    [name] => plot
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [2] => Array
                (
                    [feature_idx] => 2
                    [name] => title
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [3] => Array
                (
                    [feature_idx] => 3
                    [name] => question_id
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [4] => Array
                (
                    [feature_idx] => 4
                    [name] => question
                    [type] => Array
                        (
                            [dtype] => string
                            [_type] => Value
                        )

                )

            [5] => Array
                (
                    [feature_idx] => 5
                    [name] => answers
                    [type] => Array
                        (
                            [feature] => Array
                                (
                                    [dtype] => string
                                    [_type] => Value
                                )

                            [_type] => Sequence
                        )

                )

            [6] => Array
                (
                    [feature_idx] => 6
                    [name] => no_answer
                    [type] => Array
                        (
                            [dtype] => bool
                            [_type] => Value
                        )

                )

        )

    [rows] => Array
        (
            [0] => Array
                (
                    [row_idx] => 0
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => b440de7d-9c3f-841c-eaec-a14bdff950d1
                            [question] => How did the police arrive at the Mars mining camp?
                            [answers] => Array
                                (
                                    [0] => They arrived by train.
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [1] => Array
                (
                    [row_idx] => 1
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => a9f95c0d-121f-3ca9-1595-d497dc8bc56c
                            [question] => Who has colonized Mars 200 years in the future?
                            [answers] => Array
                                (
                                    [0] => A high-tech company has colonized Mars 200 years in the future.
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [2] => Array
                (
                    [row_idx] => 2
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => ba395c84-ea70-ce5c-d054-271de5372b0f
                            [question] => Which two people reach the headquarters alive?
                            [answers] => Array
                                (
                                    [0] => Melanie and Desolation
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [3] => Array
                (
                    [row_idx] => 3
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => fb3e18aa-e586-8452-7045-cbdba59b2efa
                            [question] => Where is Melanie Ballard?
                            [answers] => Array
                                (
                                    [0] => In a Mars mining camp which has cut all communication links with the company headquarters
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [4] => Array
                (
                    [row_idx] => 4
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => 4fe8fa6d-5fe0-523f-b0f4-2c147776338e
                            [question] => who is there with Melanie Ballard?
                            [answers] => Array
                                (
                                    [0] => She's not alone, as she is with a group of fellow police officers.
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [5] => Array
                (
                    [row_idx] => 5
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => 9e4a92a0-900d-0c2c-2722-11aa1be12027
                            [question] => What is the problem with the miners
                            [answers] => Array
                                (
                                )

                            [no_answer] => 1
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [6] => Array
                (
                    [row_idx] => 6
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => e94e0133-0eb1-50de-079e-c417a106f29e
                            [question] => Who is the only person left at the camp?
                            [answers] => Array
                                (
                                    [0] => Desolation Williams
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [7] => Array
                (
                    [row_idx] => 7
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => 8bff29a5-32de-864c-a89d-c0c85f53c45d
                            [question] => Who is colonized by a high tech company?
                            [answers] => Array
                                (
                                    [0] => mars has been colonized by a high tech company.
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [8] => Array
                (
                    [row_idx] => 8
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => de80d88a-7de0-dc5f-3608-9909634ca5ea
                            [question] => Who survives leaving the mining camp and the prison?
                            [answers] => Array
                                (
                                    [0] => Melanie and Desolation
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [9] => Array
                (
                    [row_idx] => 9
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => fb7c06df-310b-582a-174b-db178afd5438
                            [question] => Who melanie and the policemen meet?
                            [answers] => Array
                                (
                                    [0] => They find a man inside an encapsulated mining car
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [10] => Array
                (
                    [row_idx] => 10
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => 13949d2d-8ff3-d804-7e43-85907fa3867d
                            [question] => Who is the only prisoner in the camp?
                            [answers] => Array
                                (
                                    [0] => Desolation Williams
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [11] => Array
                (
                    [row_idx] => 11
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => 5e99e366-ffe7-70a7-ee97-bb029ac30fc5
                            [question] => What else reaches the headquarters along with them?
                            [answers] => Array
                                (
                                    [0] => the red dust
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [12] => Array
                (
                    [row_idx] => 12
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => e53a42cf-340f-50ff-364e-fd93c7cac788
                            [question] => How do Melanie and the police officers arrive to the Mars mining camp?
                            [answers] => Array
                                (
                                    [0] => by train
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [13] => Array
                (
                    [row_idx] => 13
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => 64f48d6b-06f4-6100-82b9-22033391df2c
                            [question] => What color was the dust when unleashed?
                            [answers] => Array
                                (
                                    [0] => Red
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [14] => Array
                (
                    [row_idx] => 14
                    [row] => Array
                        (
                            [plot_id] => /m/03vyhn
                            [plot] => 200 years in the future, Mars has been colonized by a high-tech company.
Melanie Ballard (Natasha Henstridge) arrives by train to a Mars mining camp which has cut all communication links with the company headquarters. She's not alone, as she is with a group of fellow police officers. They find the mining camp deserted except for a person in the prison, Desolation Williams (Ice Cube), who seems to laugh about them because they are all going to die. They were supposed to take Desolation to headquarters, but decide to explore first to find out what happened.They find a man inside an encapsulated mining car, who tells them not to open it. However, they do and he tries to kill them. One of the cops witnesses strange men with deep scarred and heavily tattooed faces killing the remaining survivors. The cops realise they need to leave the place fast.Desolation explains that the miners opened a kind of Martian construction in the soil which unleashed red dust. Those who breathed that dust became violent psychopaths who started to build weapons and kill the uninfected. They changed genetically, becoming distorted but much stronger.The cops and Desolation leave the prison with difficulty, and devise a plan to kill all the genetically modified ex-miners on the way out. However, the plan goes awry, and only Melanie and Desolation reach headquarters alive. Melanie realises that her bosses won't ever believe her. However, the red dust eventually arrives to headquarters, and Melanie and Desolation need to fight once again.
                            [title] => Ghosts of Mars
                            [question_id] => c522cfa2-2a92-5918-2091-25a26a95cbac
                            [question] => When does this story take place
                            [answers] => Array
                                (
                                    [0] => 200 years in the future.
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [15] => Array
                (
                    [row_idx] => 15
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 0873700f-ee26-c1c7-9f02-22fbb9984c16
                            [question] => How many years have passed by the end of the film?
                            [answers] => Array
                                (
                                    [0] => Two years.
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [16] => Array
                (
                    [row_idx] => 16
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 0aa7de5d-b47c-163f-f0c5-0aa13d12319b
                            [question] => who awakens shorly for Kumiko?
                            [answers] => Array
                                (
                                    [0] => Mitsuko
                                    [1] => Mitsuko
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [17] => Array
                (
                    [row_idx] => 17
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => ae4cff21-3dd5-4625-0f57-7efebecbaa77
                            [question] => What is the shy, teenage girl's name?
                            [answers] => Array
                                (
                                    [0] => Noriko Shimabara
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [18] => Array
                (
                    [row_idx] => 18
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 0e1d343e-72b3-20a6-b93b-94cefc377811
                            [question] => Who commits suicide?
                            [answers] => Array
                                (
                                    [0] => Tasko
                                    [1] => Tasko
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [19] => Array
                (
                    [row_idx] => 19
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 1692f116-b4eb-c7db-a115-cc34c908d4fb
                            [question] => How many girls jump in front of the train?
                            [answers] => Array
                                (
                                    [0] => 54 girls
                                    [1] => 54 girls
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [20] => Array
                (
                    [row_idx] => 20
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => aa870407-e692-1584-ba94-131512013c53
                            [question] => Who resorts to the internet after feeling alienated and misunderstood by her parents?
                            [answers] => Array
                                (
                                    [0] => Noriko
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [21] => Array
                (
                    [row_idx] => 21
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 4c46949a-1235-b10e-89c4-8be9fdc50c8e
                            [question] => In which train station does Noriko meet Ueno54?
                            [answers] => Array
                                (
                                    [0] => Ueno Train Station
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [22] => Array
                (
                    [row_idx] => 22
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => f89b398e-b704-81e9-9d85-dccbe5cf4e15
                            [question] => What is the cult's name?
                            [answers] => Array
                                (
                                    [0] => "Suicide Club"
                                    [1] => "Suicide Club"
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [23] => Array
                (
                    [row_idx] => 23
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 8dbe5f93-0445-dd3d-594b-afab11629107
                            [question] => who  who attacks them with a knife ?
                            [answers] => Array
                                (
                                    [0] => thugs
                                    [1] => thugs
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [24] => Array
                (
                    [row_idx] => 24
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => e5decaae-db08-ac70-8693-c377c662b92c
                            [question] => Where does Noriko move to?
                            [answers] => Array
                                (
                                    [0] => Tokyo
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [25] => Array
                (
                    [row_idx] => 25
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 779c5e16-6f03-5dde-15d9-b9ac0e2eef1a
                            [question] => who is wife of tetsuzo?
                            [answers] => Array
                                (
                                    [0] => Kumiko
                                    [1] => Kumiko
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [26] => Array
                (
                    [row_idx] => 26
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 418525b3-8575-b83d-bb0e-d09dfaa9c4b4
                            [question] => Whose member did Tetsuzo contacts?
                            [answers] => Array
                                (
                                    [0] => I. C. Corp
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [27] => Array
                (
                    [row_idx] => 27
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => d6b0e23a-c089-52db-382e-f193bf01b5b8
                            [question] => How old is the teenage girl?
                            [answers] => Array
                                (
                                    [0] => 17
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [28] => Array
                (
                    [row_idx] => 28
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 52fe5e44-6f40-ebfc-1dd4-684cacc76350
                            [question] => Who does Tetsuzo made to pose as a client for I. C. Corp?
                            [answers] => Array
                                (
                                    [0] => Ikeda
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [29] => Array
                (
                    [row_idx] => 29
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 2309dc59-7335-4ab0-026c-e266d63ee6f9
                            [question] => Who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation?
                            [answers] => Array
                                (
                                    [0] => I. C. Corp
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [30] => Array
                (
                    [row_idx] => 30
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => c7ddf68f-1c13-2f66-ac0e-df72ed02dfa8
                            [question] => What city does Yuka run off to?
                            [answers] => Array
                                (
                                    [0] => Tokyo
                                    [1] => Tokyo
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [31] => Array
                (
                    [row_idx] => 31
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 3d93f765-6465-4afe-ad71-c20b03be8f54
                            [question] => When does Noriko run away to Tokyo?
                            [answers] => Array
                                (
                                    [0] => December 10, 2001
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [32] => Array
                (
                    [row_idx] => 32
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => b8378e8a-2113-8418-9466-925fef3bb37e
                            [question] => How many chapters is the film divided into?
                            [answers] => Array
                                (
                                    [0] => 5
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [33] => Array
                (
                    [row_idx] => 33
                    [row] => Array
                        (
                            [plot_id] => /m/0994bg
                            [plot] => The film is divided into 5 chapters, the first four of which are named after characters in the film: Noriko, Yuka, Kumiko and Tetsuzo, in that order. The plot is told non-linearly and shifts between the perspectives of Noriko, Yuka and Tetsuzo.
A shy and demure 17-year-old teenage girl named Noriko Shimabara (Kazue Fukiishi) lives with her quiet family, formed by her sister Yuka (Yuriko Yoshitaka), her mother Taeko (Sanae Miyata), and her father Tetsuzo (Ken Mitsuishi), in Toyokawa, Japan. Noriko finds her small-town life unsatisfying and craves to move to Tokyo, assuming she would live a more active life there. This sentiment is especially encouraged when she finds that her elementary school friend Tangerine (Yoko Mitsuya) is now working independently as an idol. Noriko's father is strictly against her going to the city, and plans on having her join a local university after school.
Feeling alienated and misunderstood by her parents, Noriko resorts to the internet where she finds Haikyo.com, a website where other teenagers from Japan gather. There, after making new and unknown friends, she feels truly at "home" and eventually, on December 10, 2001, runs away from her unhappy life to Tokyo, where she plans on meeting the website's leader, a mysterious girl who uses the screen name "Ueno Station 54". Once in Tokyo, Noriko logs onto the website and contacts Ueno54. They meet up at Locker #54 in Ueno Train Station, where it is revealed that she is a young woman named Kumiko. She introduces Noriko to her family and takes Noriko to visit her grandparents. As it turns out, however, Kumiko has no real family, and the people she introduced Noriko to are paid actors working for Kumiko's organisation, I.C. Corp. The organisation offers paid roleplay services to interested clients, allowing them to fulfil their fantasies of a happy family life.
Six months later, 54 girls jump in front of a train at Shinjuku station and committ suicide while Noriko and Kumiko look on. It is implied that the 54 were members of the organization acting out their roles. Back in Toyokawa, Yuka, who was also a member of Haikyo.com, wonders if her sister was involved in the mass suicide. She writes a story speculating how her father would react if she were to disappear as well, and deliberately leaves clues before running off to Tokyo to join I.C. Corp.
Tetsuzo attempts to put on a brave face after Yuka's disappearance, but his wife Taeko's mental condition deteriorates rapidly and she eventually commits suicide. Meanwhile, Tetsuzo, a reporter, gathers clues regarding his daughters' disappearances and discovers Yuka's story. He is crushed to find that his daughter could predict his actions and behaviour so accurately while he was completely aloof of his daughters' feelings. His investigations reveal Haikyo.com and taking a cue from sensationalist media tabloids, he concludes that his daughters are part of a cult called the "Suicide Club".
Tetsuzo contacts a member of I.C. Corp, who refutes the existence of a "suicide club" and instead expounds on a concept of social roles that forms the basis of his organisation. Tetsuzo gets an old friend of his, Ikeda (Shirou Namiki) to pose as a client for I.C. Corp and rent Kumiko as his wife, and Noriko and Yuka as his daughters (who go by the aliases Mitsuko and Yoko respectively). Tetsuzo finds a house in Tokyo resembling his own and moves all the furniture from the old house to the new one, to resemble it exactly. Mitsuko and Yoko are unsettled when they arrive at the house, but fall back into their roles when prompted by Kumiko. Ikeda sends Kumiko away on an errand and Tetsuzo reveals himself. The girls, however, treat him as a stranger and insist that they are Mitsuko and Yoko, not Noriko and Yuka.
As the session falls apart, thugs from the organisation arrive on site to beat up Tetsuzo, who attacks them with a knife and kills all of them in the living room. Kumiko arrives from her errand shortly thereafter playing out her role as if nothing is wrong, but then implores Tetsuzo to kill her and run away with Noriko and Yuka. Her insistence gravely disturbs Noriko and Yuka, before Yuka interrupts the heated conversation and asks to 'extend the session'.
Finally, Tetsuzo, Kumiko, Mitsuko and Yuka dine together as a happy family and Tetsuzo begins acting as if Kumiko is his wife, calling her Taeko. Yuka does not sleep that night and at the leaves the home at crack of dawn, shedding her roles and names. Mitsuko awakens shortly thereafter and to herself, bids goodbye to Yuka, adolescence, Haikyo.com and Mitsuko, before finally declaring that she is Noriko.
By the end, two years have passed in this film and 18 months since Suicide Club.
                            [title] => Noriko's Dinner Table
                            [question_id] => 4fcc992c-f636-6fed-9e3a-771d7b99e7de
                            [question] => To beat whom  thugs from the organisation arrive?
                            [answers] => Array
                                (
                                    [0] => Tetsuzo
                                    [1] => Tetsuzo
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [34] => Array
                (
                    [row_idx] => 34
                    [row] => Array
                        (
                            [plot_id] => /m/03mdpqr
                            [plot] => This article's plot summary may be too long or excessively detailed. Please help improve it by removing unnecessary details and making it more concise. (September 2015) (Learn how and when to remove this template message)
On January 1, 2008 at the Xcalibur Bowling Centre, a disco-themed bowling alley in Surrey, British Columbia, Egerton, the janitor, has allowed two groups of teenagers to bowl against one another after hours. The "prep", Steve, is still bitter after his best friend Jamie, the "jock", had sex with Lisa, a girl with whom Steve was smitten and even took to their senior prom. After Steve and his friends Joey, Patrick, and A.J. harass the "tranny", Sam, they are chastised by Jamie. This leads to a brawl between Steve's team and Jamie's. Lisa breaks up the fight by dropping a bowling ball on Steve's foot just as Steve is about to kick Jamie again. Egerton, brandishing a shotgun, tells the teenagers to leave and they can continue their tournament the following night.
Lisa, having forgot her purse in the arcade, returns to find Steve and his friends waiting for her. Steve proceeds to violently rape Lisa while the others watch. Egerton is oblivious to Lisa's cries for help, as he is downstairs cleaning up the mess the teenagers made. After he is finished raping Lisa, Steve leaves the room. While Steve is gone, A.J. anally rapes Lisa on the pool table; then it's Joey who abuses her. Patrick, who believed the three were only going to "scare" Lisa, refuses to participate in the rape. Steve returns with a bowling pin and prepares to insert it into Lisa before Patrick intervenes. Steve retorts by giving Patrick the pin and ordering him to do it himself. Patrick refuses to do so at first but complies when Steve threatens to do the same to him. In the end Patrick penetrates Lisa with the bowling pin as she screams in pain. The four leave Lisa on the pool table, naked and barely conscious.
The following night, the two groups arrive at the bowling alley to continue their tournament. Steve is joined by his "girlfriends", Julia and Hannah. Jamie arrives late with Lisa, who barely speaks. As the teams begin their first game of the night, Lisa suddenly gets on an elevator. She is confronted by Patrick, who says he's only at the bowling alley to apologize. Lisa doesn't believe him, and insists that he is only there to make sure that she hasn't contacted the police. During the game, the players notice a mystery player on the scoreboard, BBK, but believe it is just a glitch. Dave, one of Jamie's friends, meets Julia in the bar and pays for two beers she ordered. When he discovers that one of them belongs to Steve, he asks if he can urinate in it. Julia tells him that she doesn't care and that she dislikes Steve too but hangs out with him anyway because he's dating her friend Hannah. Julia follows Dave into the bathroom and the two begin to make out. A mysterious person wearing bowling attire exits one of the stalls while Dave and Julia are in the 69 position and forces Julia's head further onto Dave's penis while forcing Dave's head further between Julia's legs, suffocating them both. After they are dead, two strikes appear next to BBK on the scoreboard in the form of a skull and crossbones.
The game continues and Sam goes to the bathroom so she can "freshen up". The person who murdered Dave and Julia is hiding in one of the stalls when Sam enters the girls' restroom and Sam, frightened by the noise coming from the stall, approaches it and is pulled inside. She tries to bargain with the killer, but the killer murders her by forcing a bowling pin down her throat. The killer lifts Sam's skirt up and, using the switchblade Sam tried to defend herself with, castrates Sam lengthwise. Later, Ben and Cindy leave to have sex in a storage room upstairs, but Ben leaves Cindy alone to buy a condom from the vending machine in the bathroom. He dies when the killer hits him over the head with a bowling pin and gouges his eyes out with a sharpened one. The killer finds Cindy upstairs and strangles her to death with a pair of bowling sneakers. Downstairs, Hannah searches for Julia but dies when the killer crushes her head with two bowling balls. Joey goes back behind the pin setters to fix his team's after noticing they were broken. A.J. notices the strikes appearing next to BBK on the scoreboard and questions Egerton about it, who assures him that it is still a glitch. Egerton sends A.J. to an area currently being remodeled with an "out of order" sign to put on an automatic ball polisher that Joey broke earlier. A.J. turns the ball polisher on and finds it already fixed but gets killed when the killer uses it to wax his face off.
Steve, noticing that something is amiss, leaves to find Joey behind the pin setters. Joey lies dead on the ground, headless. Steve is frightened by the killer, who bludgeons him with a bowling pin before sodomizing him with another sharpened pin. As Steve tries to crawl away, the killer smashes his head in with the bowling pin. Meanwhile, Sarah and Jamie continue their game. Jamie reaches into the ball return slot to find his bowling ball, instead discovering Joey's severed head. The two try desperately to escape the bowling alley before coming face to face with the killer. They run and hide in the basement, where they find their friends' bodies. The killer appears with a shotgun and removes the bowling bag to reveal Egerton's face. Sarah discovers that Jamie knew about the murders of Steve, Joey, and A.J. but not the others. Lisa appears, dressed up as well, revealing that she murdered Steve. Jamie explains that Lisa told her father, who turns out to be Egerton, about the rape and Egerton let Jamie in on the plan. When asked why he killed their friends too, Egerton explains that they didn't intervene when Lisa reentered the bowling alley and are therefore just as guilty. Another person dressed like the killer, as Egerton goes on to explain, Another killer (possibly the real "BBK") enters the basement and removes the bowling bag to reveal Patrick's face. Patrick explains that he confessed his involvement to Egerton and wanted to contact the police, but Egerton let him in on the plan instead and he was the person who murdered Joey and A.J., supposedly to make it up to her. Lisa is furious that her father allowed him to live so Egerton betrays Patrick and slits his throat with the switchblade he got from Sam. Jamie, realizing he's out of control, wrestles Egerton to the ground and, after a scuffle, blows his head clean off with the shotgun. Lisa cradles her father's body before grabbing the switchblade and trying to attack Jamie. Sarah grabs the shotgun and kills Lisa.
With the three "BBK"'s dead, Sarah shoots the locks off of the emergency doors and the two survivors escape the bowling alley. Traumatized and, above all, upset that Jamie did nothing to prevent the murders, Sarah turns the gun on him, pumps it saying: "'cuz we're both fucked". The screen cuts to black as a gunshot is heard, indicating that Sarah murdered Jamie and is on the run.
                            [title] => Gutterballs
                            [question_id] => fb548644-52c6-fcdc-f88b-ef520b726f12
                            [question] => Who murdered Jamie?
                            [answers] => Array
                                (
                                    [0] => Sarah
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [35] => Array
                (
                    [row_idx] => 35
                    [row] => Array
                        (
                            [plot_id] => /m/03mdpqr
                            [plot] => This article's plot summary may be too long or excessively detailed. Please help improve it by removing unnecessary details and making it more concise. (September 2015) (Learn how and when to remove this template message)
On January 1, 2008 at the Xcalibur Bowling Centre, a disco-themed bowling alley in Surrey, British Columbia, Egerton, the janitor, has allowed two groups of teenagers to bowl against one another after hours. The "prep", Steve, is still bitter after his best friend Jamie, the "jock", had sex with Lisa, a girl with whom Steve was smitten and even took to their senior prom. After Steve and his friends Joey, Patrick, and A.J. harass the "tranny", Sam, they are chastised by Jamie. This leads to a brawl between Steve's team and Jamie's. Lisa breaks up the fight by dropping a bowling ball on Steve's foot just as Steve is about to kick Jamie again. Egerton, brandishing a shotgun, tells the teenagers to leave and they can continue their tournament the following night.
Lisa, having forgot her purse in the arcade, returns to find Steve and his friends waiting for her. Steve proceeds to violently rape Lisa while the others watch. Egerton is oblivious to Lisa's cries for help, as he is downstairs cleaning up the mess the teenagers made. After he is finished raping Lisa, Steve leaves the room. While Steve is gone, A.J. anally rapes Lisa on the pool table; then it's Joey who abuses her. Patrick, who believed the three were only going to "scare" Lisa, refuses to participate in the rape. Steve returns with a bowling pin and prepares to insert it into Lisa before Patrick intervenes. Steve retorts by giving Patrick the pin and ordering him to do it himself. Patrick refuses to do so at first but complies when Steve threatens to do the same to him. In the end Patrick penetrates Lisa with the bowling pin as she screams in pain. The four leave Lisa on the pool table, naked and barely conscious.
The following night, the two groups arrive at the bowling alley to continue their tournament. Steve is joined by his "girlfriends", Julia and Hannah. Jamie arrives late with Lisa, who barely speaks. As the teams begin their first game of the night, Lisa suddenly gets on an elevator. She is confronted by Patrick, who says he's only at the bowling alley to apologize. Lisa doesn't believe him, and insists that he is only there to make sure that she hasn't contacted the police. During the game, the players notice a mystery player on the scoreboard, BBK, but believe it is just a glitch. Dave, one of Jamie's friends, meets Julia in the bar and pays for two beers she ordered. When he discovers that one of them belongs to Steve, he asks if he can urinate in it. Julia tells him that she doesn't care and that she dislikes Steve too but hangs out with him anyway because he's dating her friend Hannah. Julia follows Dave into the bathroom and the two begin to make out. A mysterious person wearing bowling attire exits one of the stalls while Dave and Julia are in the 69 position and forces Julia's head further onto Dave's penis while forcing Dave's head further between Julia's legs, suffocating them both. After they are dead, two strikes appear next to BBK on the scoreboard in the form of a skull and crossbones.
The game continues and Sam goes to the bathroom so she can "freshen up". The person who murdered Dave and Julia is hiding in one of the stalls when Sam enters the girls' restroom and Sam, frightened by the noise coming from the stall, approaches it and is pulled inside. She tries to bargain with the killer, but the killer murders her by forcing a bowling pin down her throat. The killer lifts Sam's skirt up and, using the switchblade Sam tried to defend herself with, castrates Sam lengthwise. Later, Ben and Cindy leave to have sex in a storage room upstairs, but Ben leaves Cindy alone to buy a condom from the vending machine in the bathroom. He dies when the killer hits him over the head with a bowling pin and gouges his eyes out with a sharpened one. The killer finds Cindy upstairs and strangles her to death with a pair of bowling sneakers. Downstairs, Hannah searches for Julia but dies when the killer crushes her head with two bowling balls. Joey goes back behind the pin setters to fix his team's after noticing they were broken. A.J. notices the strikes appearing next to BBK on the scoreboard and questions Egerton about it, who assures him that it is still a glitch. Egerton sends A.J. to an area currently being remodeled with an "out of order" sign to put on an automatic ball polisher that Joey broke earlier. A.J. turns the ball polisher on and finds it already fixed but gets killed when the killer uses it to wax his face off.
Steve, noticing that something is amiss, leaves to find Joey behind the pin setters. Joey lies dead on the ground, headless. Steve is frightened by the killer, who bludgeons him with a bowling pin before sodomizing him with another sharpened pin. As Steve tries to crawl away, the killer smashes his head in with the bowling pin. Meanwhile, Sarah and Jamie continue their game. Jamie reaches into the ball return slot to find his bowling ball, instead discovering Joey's severed head. The two try desperately to escape the bowling alley before coming face to face with the killer. They run and hide in the basement, where they find their friends' bodies. The killer appears with a shotgun and removes the bowling bag to reveal Egerton's face. Sarah discovers that Jamie knew about the murders of Steve, Joey, and A.J. but not the others. Lisa appears, dressed up as well, revealing that she murdered Steve. Jamie explains that Lisa told her father, who turns out to be Egerton, about the rape and Egerton let Jamie in on the plan. When asked why he killed their friends too, Egerton explains that they didn't intervene when Lisa reentered the bowling alley and are therefore just as guilty. Another person dressed like the killer, as Egerton goes on to explain, Another killer (possibly the real "BBK") enters the basement and removes the bowling bag to reveal Patrick's face. Patrick explains that he confessed his involvement to Egerton and wanted to contact the police, but Egerton let him in on the plan instead and he was the person who murdered Joey and A.J., supposedly to make it up to her. Lisa is furious that her father allowed him to live so Egerton betrays Patrick and slits his throat with the switchblade he got from Sam. Jamie, realizing he's out of control, wrestles Egerton to the ground and, after a scuffle, blows his head clean off with the shotgun. Lisa cradles her father's body before grabbing the switchblade and trying to attack Jamie. Sarah grabs the shotgun and kills Lisa.
With the three "BBK"'s dead, Sarah shoots the locks off of the emergency doors and the two survivors escape the bowling alley. Traumatized and, above all, upset that Jamie did nothing to prevent the murders, Sarah turns the gun on him, pumps it saying: "'cuz we're both fucked". The screen cuts to black as a gunshot is heard, indicating that Sarah murdered Jamie and is on the run.
                            [title] => Gutterballs
                            [question_id] => 7feaf630-0d2b-3e1c-bebb-4149551f028e
                            [question] => What does Jamie find in the ball return slot when he reaches to get his bowling ball?
                            [answers] => Array
                                (
                                    [0] => Joey's severed head
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [36] => Array
                (
                    [row_idx] => 36
                    [row] => Array
                        (
                            [plot_id] => /m/03mdpqr
                            [plot] => This article's plot summary may be too long or excessively detailed. Please help improve it by removing unnecessary details and making it more concise. (September 2015) (Learn how and when to remove this template message)
On January 1, 2008 at the Xcalibur Bowling Centre, a disco-themed bowling alley in Surrey, British Columbia, Egerton, the janitor, has allowed two groups of teenagers to bowl against one another after hours. The "prep", Steve, is still bitter after his best friend Jamie, the "jock", had sex with Lisa, a girl with whom Steve was smitten and even took to their senior prom. After Steve and his friends Joey, Patrick, and A.J. harass the "tranny", Sam, they are chastised by Jamie. This leads to a brawl between Steve's team and Jamie's. Lisa breaks up the fight by dropping a bowling ball on Steve's foot just as Steve is about to kick Jamie again. Egerton, brandishing a shotgun, tells the teenagers to leave and they can continue their tournament the following night.
Lisa, having forgot her purse in the arcade, returns to find Steve and his friends waiting for her. Steve proceeds to violently rape Lisa while the others watch. Egerton is oblivious to Lisa's cries for help, as he is downstairs cleaning up the mess the teenagers made. After he is finished raping Lisa, Steve leaves the room. While Steve is gone, A.J. anally rapes Lisa on the pool table; then it's Joey who abuses her. Patrick, who believed the three were only going to "scare" Lisa, refuses to participate in the rape. Steve returns with a bowling pin and prepares to insert it into Lisa before Patrick intervenes. Steve retorts by giving Patrick the pin and ordering him to do it himself. Patrick refuses to do so at first but complies when Steve threatens to do the same to him. In the end Patrick penetrates Lisa with the bowling pin as she screams in pain. The four leave Lisa on the pool table, naked and barely conscious.
The following night, the two groups arrive at the bowling alley to continue their tournament. Steve is joined by his "girlfriends", Julia and Hannah. Jamie arrives late with Lisa, who barely speaks. As the teams begin their first game of the night, Lisa suddenly gets on an elevator. She is confronted by Patrick, who says he's only at the bowling alley to apologize. Lisa doesn't believe him, and insists that he is only there to make sure that she hasn't contacted the police. During the game, the players notice a mystery player on the scoreboard, BBK, but believe it is just a glitch. Dave, one of Jamie's friends, meets Julia in the bar and pays for two beers she ordered. When he discovers that one of them belongs to Steve, he asks if he can urinate in it. Julia tells him that she doesn't care and that she dislikes Steve too but hangs out with him anyway because he's dating her friend Hannah. Julia follows Dave into the bathroom and the two begin to make out. A mysterious person wearing bowling attire exits one of the stalls while Dave and Julia are in the 69 position and forces Julia's head further onto Dave's penis while forcing Dave's head further between Julia's legs, suffocating them both. After they are dead, two strikes appear next to BBK on the scoreboard in the form of a skull and crossbones.
The game continues and Sam goes to the bathroom so she can "freshen up". The person who murdered Dave and Julia is hiding in one of the stalls when Sam enters the girls' restroom and Sam, frightened by the noise coming from the stall, approaches it and is pulled inside. She tries to bargain with the killer, but the killer murders her by forcing a bowling pin down her throat. The killer lifts Sam's skirt up and, using the switchblade Sam tried to defend herself with, castrates Sam lengthwise. Later, Ben and Cindy leave to have sex in a storage room upstairs, but Ben leaves Cindy alone to buy a condom from the vending machine in the bathroom. He dies when the killer hits him over the head with a bowling pin and gouges his eyes out with a sharpened one. The killer finds Cindy upstairs and strangles her to death with a pair of bowling sneakers. Downstairs, Hannah searches for Julia but dies when the killer crushes her head with two bowling balls. Joey goes back behind the pin setters to fix his team's after noticing they were broken. A.J. notices the strikes appearing next to BBK on the scoreboard and questions Egerton about it, who assures him that it is still a glitch. Egerton sends A.J. to an area currently being remodeled with an "out of order" sign to put on an automatic ball polisher that Joey broke earlier. A.J. turns the ball polisher on and finds it already fixed but gets killed when the killer uses it to wax his face off.
Steve, noticing that something is amiss, leaves to find Joey behind the pin setters. Joey lies dead on the ground, headless. Steve is frightened by the killer, who bludgeons him with a bowling pin before sodomizing him with another sharpened pin. As Steve tries to crawl away, the killer smashes his head in with the bowling pin. Meanwhile, Sarah and Jamie continue their game. Jamie reaches into the ball return slot to find his bowling ball, instead discovering Joey's severed head. The two try desperately to escape the bowling alley before coming face to face with the killer. They run and hide in the basement, where they find their friends' bodies. The killer appears with a shotgun and removes the bowling bag to reveal Egerton's face. Sarah discovers that Jamie knew about the murders of Steve, Joey, and A.J. but not the others. Lisa appears, dressed up as well, revealing that she murdered Steve. Jamie explains that Lisa told her father, who turns out to be Egerton, about the rape and Egerton let Jamie in on the plan. When asked why he killed their friends too, Egerton explains that they didn't intervene when Lisa reentered the bowling alley and are therefore just as guilty. Another person dressed like the killer, as Egerton goes on to explain, Another killer (possibly the real "BBK") enters the basement and removes the bowling bag to reveal Patrick's face. Patrick explains that he confessed his involvement to Egerton and wanted to contact the police, but Egerton let him in on the plan instead and he was the person who murdered Joey and A.J., supposedly to make it up to her. Lisa is furious that her father allowed him to live so Egerton betrays Patrick and slits his throat with the switchblade he got from Sam. Jamie, realizing he's out of control, wrestles Egerton to the ground and, after a scuffle, blows his head clean off with the shotgun. Lisa cradles her father's body before grabbing the switchblade and trying to attack Jamie. Sarah grabs the shotgun and kills Lisa.
With the three "BBK"'s dead, Sarah shoots the locks off of the emergency doors and the two survivors escape the bowling alley. Traumatized and, above all, upset that Jamie did nothing to prevent the murders, Sarah turns the gun on him, pumps it saying: "'cuz we're both fucked". The screen cuts to black as a gunshot is heard, indicating that Sarah murdered Jamie and is on the run.
                            [title] => Gutterballs
                            [question_id] => 9b50e6ef-75de-0899-afd3-cde00fd59cf8
                            [question] => Who forgot there purse in the archade?
                            [answers] => Array
                                (
                                    [0] => Lisa
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [37] => Array
                (
                    [row_idx] => 37
                    [row] => Array
                        (
                            [plot_id] => /m/03mdpqr
                            [plot] => This article's plot summary may be too long or excessively detailed. Please help improve it by removing unnecessary details and making it more concise. (September 2015) (Learn how and when to remove this template message)
On January 1, 2008 at the Xcalibur Bowling Centre, a disco-themed bowling alley in Surrey, British Columbia, Egerton, the janitor, has allowed two groups of teenagers to bowl against one another after hours. The "prep", Steve, is still bitter after his best friend Jamie, the "jock", had sex with Lisa, a girl with whom Steve was smitten and even took to their senior prom. After Steve and his friends Joey, Patrick, and A.J. harass the "tranny", Sam, they are chastised by Jamie. This leads to a brawl between Steve's team and Jamie's. Lisa breaks up the fight by dropping a bowling ball on Steve's foot just as Steve is about to kick Jamie again. Egerton, brandishing a shotgun, tells the teenagers to leave and they can continue their tournament the following night.
Lisa, having forgot her purse in the arcade, returns to find Steve and his friends waiting for her. Steve proceeds to violently rape Lisa while the others watch. Egerton is oblivious to Lisa's cries for help, as he is downstairs cleaning up the mess the teenagers made. After he is finished raping Lisa, Steve leaves the room. While Steve is gone, A.J. anally rapes Lisa on the pool table; then it's Joey who abuses her. Patrick, who believed the three were only going to "scare" Lisa, refuses to participate in the rape. Steve returns with a bowling pin and prepares to insert it into Lisa before Patrick intervenes. Steve retorts by giving Patrick the pin and ordering him to do it himself. Patrick refuses to do so at first but complies when Steve threatens to do the same to him. In the end Patrick penetrates Lisa with the bowling pin as she screams in pain. The four leave Lisa on the pool table, naked and barely conscious.
The following night, the two groups arrive at the bowling alley to continue their tournament. Steve is joined by his "girlfriends", Julia and Hannah. Jamie arrives late with Lisa, who barely speaks. As the teams begin their first game of the night, Lisa suddenly gets on an elevator. She is confronted by Patrick, who says he's only at the bowling alley to apologize. Lisa doesn't believe him, and insists that he is only there to make sure that she hasn't contacted the police. During the game, the players notice a mystery player on the scoreboard, BBK, but believe it is just a glitch. Dave, one of Jamie's friends, meets Julia in the bar and pays for two beers she ordered. When he discovers that one of them belongs to Steve, he asks if he can urinate in it. Julia tells him that she doesn't care and that she dislikes Steve too but hangs out with him anyway because he's dating her friend Hannah. Julia follows Dave into the bathroom and the two begin to make out. A mysterious person wearing bowling attire exits one of the stalls while Dave and Julia are in the 69 position and forces Julia's head further onto Dave's penis while forcing Dave's head further between Julia's legs, suffocating them both. After they are dead, two strikes appear next to BBK on the scoreboard in the form of a skull and crossbones.
The game continues and Sam goes to the bathroom so she can "freshen up". The person who murdered Dave and Julia is hiding in one of the stalls when Sam enters the girls' restroom and Sam, frightened by the noise coming from the stall, approaches it and is pulled inside. She tries to bargain with the killer, but the killer murders her by forcing a bowling pin down her throat. The killer lifts Sam's skirt up and, using the switchblade Sam tried to defend herself with, castrates Sam lengthwise. Later, Ben and Cindy leave to have sex in a storage room upstairs, but Ben leaves Cindy alone to buy a condom from the vending machine in the bathroom. He dies when the killer hits him over the head with a bowling pin and gouges his eyes out with a sharpened one. The killer finds Cindy upstairs and strangles her to death with a pair of bowling sneakers. Downstairs, Hannah searches for Julia but dies when the killer crushes her head with two bowling balls. Joey goes back behind the pin setters to fix his team's after noticing they were broken. A.J. notices the strikes appearing next to BBK on the scoreboard and questions Egerton about it, who assures him that it is still a glitch. Egerton sends A.J. to an area currently being remodeled with an "out of order" sign to put on an automatic ball polisher that Joey broke earlier. A.J. turns the ball polisher on and finds it already fixed but gets killed when the killer uses it to wax his face off.
Steve, noticing that something is amiss, leaves to find Joey behind the pin setters. Joey lies dead on the ground, headless. Steve is frightened by the killer, who bludgeons him with a bowling pin before sodomizing him with another sharpened pin. As Steve tries to crawl away, the killer smashes his head in with the bowling pin. Meanwhile, Sarah and Jamie continue their game. Jamie reaches into the ball return slot to find his bowling ball, instead discovering Joey's severed head. The two try desperately to escape the bowling alley before coming face to face with the killer. They run and hide in the basement, where they find their friends' bodies. The killer appears with a shotgun and removes the bowling bag to reveal Egerton's face. Sarah discovers that Jamie knew about the murders of Steve, Joey, and A.J. but not the others. Lisa appears, dressed up as well, revealing that she murdered Steve. Jamie explains that Lisa told her father, who turns out to be Egerton, about the rape and Egerton let Jamie in on the plan. When asked why he killed their friends too, Egerton explains that they didn't intervene when Lisa reentered the bowling alley and are therefore just as guilty. Another person dressed like the killer, as Egerton goes on to explain, Another killer (possibly the real "BBK") enters the basement and removes the bowling bag to reveal Patrick's face. Patrick explains that he confessed his involvement to Egerton and wanted to contact the police, but Egerton let him in on the plan instead and he was the person who murdered Joey and A.J., supposedly to make it up to her. Lisa is furious that her father allowed him to live so Egerton betrays Patrick and slits his throat with the switchblade he got from Sam. Jamie, realizing he's out of control, wrestles Egerton to the ground and, after a scuffle, blows his head clean off with the shotgun. Lisa cradles her father's body before grabbing the switchblade and trying to attack Jamie. Sarah grabs the shotgun and kills Lisa.
With the three "BBK"'s dead, Sarah shoots the locks off of the emergency doors and the two survivors escape the bowling alley. Traumatized and, above all, upset that Jamie did nothing to prevent the murders, Sarah turns the gun on him, pumps it saying: "'cuz we're both fucked". The screen cuts to black as a gunshot is heard, indicating that Sarah murdered Jamie and is on the run.
                            [title] => Gutterballs
                            [question_id] => 64d2307b-a829-49c6-b859-5984f6b05d21
                            [question] => WHO IS WAITING FOR LISA WHEN SHE RETURN IN THE ARCADE?
                            [answers] => Array
                                (
                                    [0] => STEVE AND HIS FRIENDS.
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [38] => Array
                (
                    [row_idx] => 38
                    [row] => Array
                        (
                            [plot_id] => /m/03mdpqr
                            [plot] => This article's plot summary may be too long or excessively detailed. Please help improve it by removing unnecessary details and making it more concise. (September 2015) (Learn how and when to remove this template message)
On January 1, 2008 at the Xcalibur Bowling Centre, a disco-themed bowling alley in Surrey, British Columbia, Egerton, the janitor, has allowed two groups of teenagers to bowl against one another after hours. The "prep", Steve, is still bitter after his best friend Jamie, the "jock", had sex with Lisa, a girl with whom Steve was smitten and even took to their senior prom. After Steve and his friends Joey, Patrick, and A.J. harass the "tranny", Sam, they are chastised by Jamie. This leads to a brawl between Steve's team and Jamie's. Lisa breaks up the fight by dropping a bowling ball on Steve's foot just as Steve is about to kick Jamie again. Egerton, brandishing a shotgun, tells the teenagers to leave and they can continue their tournament the following night.
Lisa, having forgot her purse in the arcade, returns to find Steve and his friends waiting for her. Steve proceeds to violently rape Lisa while the others watch. Egerton is oblivious to Lisa's cries for help, as he is downstairs cleaning up the mess the teenagers made. After he is finished raping Lisa, Steve leaves the room. While Steve is gone, A.J. anally rapes Lisa on the pool table; then it's Joey who abuses her. Patrick, who believed the three were only going to "scare" Lisa, refuses to participate in the rape. Steve returns with a bowling pin and prepares to insert it into Lisa before Patrick intervenes. Steve retorts by giving Patrick the pin and ordering him to do it himself. Patrick refuses to do so at first but complies when Steve threatens to do the same to him. In the end Patrick penetrates Lisa with the bowling pin as she screams in pain. The four leave Lisa on the pool table, naked and barely conscious.
The following night, the two groups arrive at the bowling alley to continue their tournament. Steve is joined by his "girlfriends", Julia and Hannah. Jamie arrives late with Lisa, who barely speaks. As the teams begin their first game of the night, Lisa suddenly gets on an elevator. She is confronted by Patrick, who says he's only at the bowling alley to apologize. Lisa doesn't believe him, and insists that he is only there to make sure that she hasn't contacted the police. During the game, the players notice a mystery player on the scoreboard, BBK, but believe it is just a glitch. Dave, one of Jamie's friends, meets Julia in the bar and pays for two beers she ordered. When he discovers that one of them belongs to Steve, he asks if he can urinate in it. Julia tells him that she doesn't care and that she dislikes Steve too but hangs out with him anyway because he's dating her friend Hannah. Julia follows Dave into the bathroom and the two begin to make out. A mysterious person wearing bowling attire exits one of the stalls while Dave and Julia are in the 69 position and forces Julia's head further onto Dave's penis while forcing Dave's head further between Julia's legs, suffocating them both. After they are dead, two strikes appear next to BBK on the scoreboard in the form of a skull and crossbones.
The game continues and Sam goes to the bathroom so she can "freshen up". The person who murdered Dave and Julia is hiding in one of the stalls when Sam enters the girls' restroom and Sam, frightened by the noise coming from the stall, approaches it and is pulled inside. She tries to bargain with the killer, but the killer murders her by forcing a bowling pin down her throat. The killer lifts Sam's skirt up and, using the switchblade Sam tried to defend herself with, castrates Sam lengthwise. Later, Ben and Cindy leave to have sex in a storage room upstairs, but Ben leaves Cindy alone to buy a condom from the vending machine in the bathroom. He dies when the killer hits him over the head with a bowling pin and gouges his eyes out with a sharpened one. The killer finds Cindy upstairs and strangles her to death with a pair of bowling sneakers. Downstairs, Hannah searches for Julia but dies when the killer crushes her head with two bowling balls. Joey goes back behind the pin setters to fix his team's after noticing they were broken. A.J. notices the strikes appearing next to BBK on the scoreboard and questions Egerton about it, who assures him that it is still a glitch. Egerton sends A.J. to an area currently being remodeled with an "out of order" sign to put on an automatic ball polisher that Joey broke earlier. A.J. turns the ball polisher on and finds it already fixed but gets killed when the killer uses it to wax his face off.
Steve, noticing that something is amiss, leaves to find Joey behind the pin setters. Joey lies dead on the ground, headless. Steve is frightened by the killer, who bludgeons him with a bowling pin before sodomizing him with another sharpened pin. As Steve tries to crawl away, the killer smashes his head in with the bowling pin. Meanwhile, Sarah and Jamie continue their game. Jamie reaches into the ball return slot to find his bowling ball, instead discovering Joey's severed head. The two try desperately to escape the bowling alley before coming face to face with the killer. They run and hide in the basement, where they find their friends' bodies. The killer appears with a shotgun and removes the bowling bag to reveal Egerton's face. Sarah discovers that Jamie knew about the murders of Steve, Joey, and A.J. but not the others. Lisa appears, dressed up as well, revealing that she murdered Steve. Jamie explains that Lisa told her father, who turns out to be Egerton, about the rape and Egerton let Jamie in on the plan. When asked why he killed their friends too, Egerton explains that they didn't intervene when Lisa reentered the bowling alley and are therefore just as guilty. Another person dressed like the killer, as Egerton goes on to explain, Another killer (possibly the real "BBK") enters the basement and removes the bowling bag to reveal Patrick's face. Patrick explains that he confessed his involvement to Egerton and wanted to contact the police, but Egerton let him in on the plan instead and he was the person who murdered Joey and A.J., supposedly to make it up to her. Lisa is furious that her father allowed him to live so Egerton betrays Patrick and slits his throat with the switchblade he got from Sam. Jamie, realizing he's out of control, wrestles Egerton to the ground and, after a scuffle, blows his head clean off with the shotgun. Lisa cradles her father's body before grabbing the switchblade and trying to attack Jamie. Sarah grabs the shotgun and kills Lisa.
With the three "BBK"'s dead, Sarah shoots the locks off of the emergency doors and the two survivors escape the bowling alley. Traumatized and, above all, upset that Jamie did nothing to prevent the murders, Sarah turns the gun on him, pumps it saying: "'cuz we're both fucked". The screen cuts to black as a gunshot is heard, indicating that Sarah murdered Jamie and is on the run.
                            [title] => Gutterballs
                            [question_id] => 6c683364-98e4-b0db-f9ab-02e79c269820
                            [question] => Why does Ben leave Cindy alone?
                            [answers] => Array
                                (
                                    [0] => To buy a condom
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [39] => Array
                (
                    [row_idx] => 39
                    [row] => Array
                        (
                            [plot_id] => /m/03mdpqr
                            [plot] => This article's plot summary may be too long or excessively detailed. Please help improve it by removing unnecessary details and making it more concise. (September 2015) (Learn how and when to remove this template message)
On January 1, 2008 at the Xcalibur Bowling Centre, a disco-themed bowling alley in Surrey, British Columbia, Egerton, the janitor, has allowed two groups of teenagers to bowl against one another after hours. The "prep", Steve, is still bitter after his best friend Jamie, the "jock", had sex with Lisa, a girl with whom Steve was smitten and even took to their senior prom. After Steve and his friends Joey, Patrick, and A.J. harass the "tranny", Sam, they are chastised by Jamie. This leads to a brawl between Steve's team and Jamie's. Lisa breaks up the fight by dropping a bowling ball on Steve's foot just as Steve is about to kick Jamie again. Egerton, brandishing a shotgun, tells the teenagers to leave and they can continue their tournament the following night.
Lisa, having forgot her purse in the arcade, returns to find Steve and his friends waiting for her. Steve proceeds to violently rape Lisa while the others watch. Egerton is oblivious to Lisa's cries for help, as he is downstairs cleaning up the mess the teenagers made. After he is finished raping Lisa, Steve leaves the room. While Steve is gone, A.J. anally rapes Lisa on the pool table; then it's Joey who abuses her. Patrick, who believed the three were only going to "scare" Lisa, refuses to participate in the rape. Steve returns with a bowling pin and prepares to insert it into Lisa before Patrick intervenes. Steve retorts by giving Patrick the pin and ordering him to do it himself. Patrick refuses to do so at first but complies when Steve threatens to do the same to him. In the end Patrick penetrates Lisa with the bowling pin as she screams in pain. The four leave Lisa on the pool table, naked and barely conscious.
The following night, the two groups arrive at the bowling alley to continue their tournament. Steve is joined by his "girlfriends", Julia and Hannah. Jamie arrives late with Lisa, who barely speaks. As the teams begin their first game of the night, Lisa suddenly gets on an elevator. She is confronted by Patrick, who says he's only at the bowling alley to apologize. Lisa doesn't believe him, and insists that he is only there to make sure that she hasn't contacted the police. During the game, the players notice a mystery player on the scoreboard, BBK, but believe it is just a glitch. Dave, one of Jamie's friends, meets Julia in the bar and pays for two beers she ordered. When he discovers that one of them belongs to Steve, he asks if he can urinate in it. Julia tells him that she doesn't care and that she dislikes Steve too but hangs out with him anyway because he's dating her friend Hannah. Julia follows Dave into the bathroom and the two begin to make out. A mysterious person wearing bowling attire exits one of the stalls while Dave and Julia are in the 69 position and forces Julia's head further onto Dave's penis while forcing Dave's head further between Julia's legs, suffocating them both. After they are dead, two strikes appear next to BBK on the scoreboard in the form of a skull and crossbones.
The game continues and Sam goes to the bathroom so she can "freshen up". The person who murdered Dave and Julia is hiding in one of the stalls when Sam enters the girls' restroom and Sam, frightened by the noise coming from the stall, approaches it and is pulled inside. She tries to bargain with the killer, but the killer murders her by forcing a bowling pin down her throat. The killer lifts Sam's skirt up and, using the switchblade Sam tried to defend herself with, castrates Sam lengthwise. Later, Ben and Cindy leave to have sex in a storage room upstairs, but Ben leaves Cindy alone to buy a condom from the vending machine in the bathroom. He dies when the killer hits him over the head with a bowling pin and gouges his eyes out with a sharpened one. The killer finds Cindy upstairs and strangles her to death with a pair of bowling sneakers. Downstairs, Hannah searches for Julia but dies when the killer crushes her head with two bowling balls. Joey goes back behind the pin setters to fix his team's after noticing they were broken. A.J. notices the strikes appearing next to BBK on the scoreboard and questions Egerton about it, who assures him that it is still a glitch. Egerton sends A.J. to an area currently being remodeled with an "out of order" sign to put on an automatic ball polisher that Joey broke earlier. A.J. turns the ball polisher on and finds it already fixed but gets killed when the killer uses it to wax his face off.
Steve, noticing that something is amiss, leaves to find Joey behind the pin setters. Joey lies dead on the ground, headless. Steve is frightened by the killer, who bludgeons him with a bowling pin before sodomizing him with another sharpened pin. As Steve tries to crawl away, the killer smashes his head in with the bowling pin. Meanwhile, Sarah and Jamie continue their game. Jamie reaches into the ball return slot to find his bowling ball, instead discovering Joey's severed head. The two try desperately to escape the bowling alley before coming face to face with the killer. They run and hide in the basement, where they find their friends' bodies. The killer appears with a shotgun and removes the bowling bag to reveal Egerton's face. Sarah discovers that Jamie knew about the murders of Steve, Joey, and A.J. but not the others. Lisa appears, dressed up as well, revealing that she murdered Steve. Jamie explains that Lisa told her father, who turns out to be Egerton, about the rape and Egerton let Jamie in on the plan. When asked why he killed their friends too, Egerton explains that they didn't intervene when Lisa reentered the bowling alley and are therefore just as guilty. Another person dressed like the killer, as Egerton goes on to explain, Another killer (possibly the real "BBK") enters the basement and removes the bowling bag to reveal Patrick's face. Patrick explains that he confessed his involvement to Egerton and wanted to contact the police, but Egerton let him in on the plan instead and he was the person who murdered Joey and A.J., supposedly to make it up to her. Lisa is furious that her father allowed him to live so Egerton betrays Patrick and slits his throat with the switchblade he got from Sam. Jamie, realizing he's out of control, wrestles Egerton to the ground and, after a scuffle, blows his head clean off with the shotgun. Lisa cradles her father's body before grabbing the switchblade and trying to attack Jamie. Sarah grabs the shotgun and kills Lisa.
With the three "BBK"'s dead, Sarah shoots the locks off of the emergency doors and the two survivors escape the bowling alley. Traumatized and, above all, upset that Jamie did nothing to prevent the murders, Sarah turns the gun on him, pumps it saying: "'cuz we're both fucked". The screen cuts to black as a gunshot is heard, indicating that Sarah murdered Jamie and is on the run.
                            [title] => Gutterballs
                            [question_id] => 159aa1a7-71f0-6196-c656-cb3d60781aa4
                            [question] => Who penetrates Lisa with a bowling pin?
                            [answers] => Array
                                (
                                    [0] => Patrick
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [40] => Array
                (
                    [row_idx] => 40
                    [row] => Array
                        (
                            [plot_id] => /m/03mdpqr
                            [plot] => This article's plot summary may be too long or excessively detailed. Please help improve it by removing unnecessary details and making it more concise. (September 2015) (Learn how and when to remove this template message)
On January 1, 2008 at the Xcalibur Bowling Centre, a disco-themed bowling alley in Surrey, British Columbia, Egerton, the janitor, has allowed two groups of teenagers to bowl against one another after hours. The "prep", Steve, is still bitter after his best friend Jamie, the "jock", had sex with Lisa, a girl with whom Steve was smitten and even took to their senior prom. After Steve and his friends Joey, Patrick, and A.J. harass the "tranny", Sam, they are chastised by Jamie. This leads to a brawl between Steve's team and Jamie's. Lisa breaks up the fight by dropping a bowling ball on Steve's foot just as Steve is about to kick Jamie again. Egerton, brandishing a shotgun, tells the teenagers to leave and they can continue their tournament the following night.
Lisa, having forgot her purse in the arcade, returns to find Steve and his friends waiting for her. Steve proceeds to violently rape Lisa while the others watch. Egerton is oblivious to Lisa's cries for help, as he is downstairs cleaning up the mess the teenagers made. After he is finished raping Lisa, Steve leaves the room. While Steve is gone, A.J. anally rapes Lisa on the pool table; then it's Joey who abuses her. Patrick, who believed the three were only going to "scare" Lisa, refuses to participate in the rape. Steve returns with a bowling pin and prepares to insert it into Lisa before Patrick intervenes. Steve retorts by giving Patrick the pin and ordering him to do it himself. Patrick refuses to do so at first but complies when Steve threatens to do the same to him. In the end Patrick penetrates Lisa with the bowling pin as she screams in pain. The four leave Lisa on the pool table, naked and barely conscious.
The following night, the two groups arrive at the bowling alley to continue their tournament. Steve is joined by his "girlfriends", Julia and Hannah. Jamie arrives late with Lisa, who barely speaks. As the teams begin their first game of the night, Lisa suddenly gets on an elevator. She is confronted by Patrick, who says he's only at the bowling alley to apologize. Lisa doesn't believe him, and insists that he is only there to make sure that she hasn't contacted the police. During the game, the players notice a mystery player on the scoreboard, BBK, but believe it is just a glitch. Dave, one of Jamie's friends, meets Julia in the bar and pays for two beers she ordered. When he discovers that one of them belongs to Steve, he asks if he can urinate in it. Julia tells him that she doesn't care and that she dislikes Steve too but hangs out with him anyway because he's dating her friend Hannah. Julia follows Dave into the bathroom and the two begin to make out. A mysterious person wearing bowling attire exits one of the stalls while Dave and Julia are in the 69 position and forces Julia's head further onto Dave's penis while forcing Dave's head further between Julia's legs, suffocating them both. After they are dead, two strikes appear next to BBK on the scoreboard in the form of a skull and crossbones.
The game continues and Sam goes to the bathroom so she can "freshen up". The person who murdered Dave and Julia is hiding in one of the stalls when Sam enters the girls' restroom and Sam, frightened by the noise coming from the stall, approaches it and is pulled inside. She tries to bargain with the killer, but the killer murders her by forcing a bowling pin down her throat. The killer lifts Sam's skirt up and, using the switchblade Sam tried to defend herself with, castrates Sam lengthwise. Later, Ben and Cindy leave to have sex in a storage room upstairs, but Ben leaves Cindy alone to buy a condom from the vending machine in the bathroom. He dies when the killer hits him over the head with a bowling pin and gouges his eyes out with a sharpened one. The killer finds Cindy upstairs and strangles her to death with a pair of bowling sneakers. Downstairs, Hannah searches for Julia but dies when the killer crushes her head with two bowling balls. Joey goes back behind the pin setters to fix his team's after noticing they were broken. A.J. notices the strikes appearing next to BBK on the scoreboard and questions Egerton about it, who assures him that it is still a glitch. Egerton sends A.J. to an area currently being remodeled with an "out of order" sign to put on an automatic ball polisher that Joey broke earlier. A.J. turns the ball polisher on and finds it already fixed but gets killed when the killer uses it to wax his face off.
Steve, noticing that something is amiss, leaves to find Joey behind the pin setters. Joey lies dead on the ground, headless. Steve is frightened by the killer, who bludgeons him with a bowling pin before sodomizing him with another sharpened pin. As Steve tries to crawl away, the killer smashes his head in with the bowling pin. Meanwhile, Sarah and Jamie continue their game. Jamie reaches into the ball return slot to find his bowling ball, instead discovering Joey's severed head. The two try desperately to escape the bowling alley before coming face to face with the killer. They run and hide in the basement, where they find their friends' bodies. The killer appears with a shotgun and removes the bowling bag to reveal Egerton's face. Sarah discovers that Jamie knew about the murders of Steve, Joey, and A.J. but not the others. Lisa appears, dressed up as well, revealing that she murdered Steve. Jamie explains that Lisa told her father, who turns out to be Egerton, about the rape and Egerton let Jamie in on the plan. When asked why he killed their friends too, Egerton explains that they didn't intervene when Lisa reentered the bowling alley and are therefore just as guilty. Another person dressed like the killer, as Egerton goes on to explain, Another killer (possibly the real "BBK") enters the basement and removes the bowling bag to reveal Patrick's face. Patrick explains that he confessed his involvement to Egerton and wanted to contact the police, but Egerton let him in on the plan instead and he was the person who murdered Joey and A.J., supposedly to make it up to her. Lisa is furious that her father allowed him to live so Egerton betrays Patrick and slits his throat with the switchblade he got from Sam. Jamie, realizing he's out of control, wrestles Egerton to the ground and, after a scuffle, blows his head clean off with the shotgun. Lisa cradles her father's body before grabbing the switchblade and trying to attack Jamie. Sarah grabs the shotgun and kills Lisa.
With the three "BBK"'s dead, Sarah shoots the locks off of the emergency doors and the two survivors escape the bowling alley. Traumatized and, above all, upset that Jamie did nothing to prevent the murders, Sarah turns the gun on him, pumps it saying: "'cuz we're both fucked". The screen cuts to black as a gunshot is heard, indicating that Sarah murdered Jamie and is on the run.
                            [title] => Gutterballs
                            [question_id] => 9a28eb34-ccd2-211d-0ba5-46368519ed91
                            [question] => Who wrestles Egerton to the ground?
                            [answers] => Array
                                (
                                    [0] => Jamie
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [41] => Array
                (
                    [row_idx] => 41
                    [row] => Array
                        (
                            [plot_id] => /m/03mdpqr
                            [plot] => This article's plot summary may be too long or excessively detailed. Please help improve it by removing unnecessary details and making it more concise. (September 2015) (Learn how and when to remove this template message)
On January 1, 2008 at the Xcalibur Bowling Centre, a disco-themed bowling alley in Surrey, British Columbia, Egerton, the janitor, has allowed two groups of teenagers to bowl against one another after hours. The "prep", Steve, is still bitter after his best friend Jamie, the "jock", had sex with Lisa, a girl with whom Steve was smitten and even took to their senior prom. After Steve and his friends Joey, Patrick, and A.J. harass the "tranny", Sam, they are chastised by Jamie. This leads to a brawl between Steve's team and Jamie's. Lisa breaks up the fight by dropping a bowling ball on Steve's foot just as Steve is about to kick Jamie again. Egerton, brandishing a shotgun, tells the teenagers to leave and they can continue their tournament the following night.
Lisa, having forgot her purse in the arcade, returns to find Steve and his friends waiting for her. Steve proceeds to violently rape Lisa while the others watch. Egerton is oblivious to Lisa's cries for help, as he is downstairs cleaning up the mess the teenagers made. After he is finished raping Lisa, Steve leaves the room. While Steve is gone, A.J. anally rapes Lisa on the pool table; then it's Joey who abuses her. Patrick, who believed the three were only going to "scare" Lisa, refuses to participate in the rape. Steve returns with a bowling pin and prepares to insert it into Lisa before Patrick intervenes. Steve retorts by giving Patrick the pin and ordering him to do it himself. Patrick refuses to do so at first but complies when Steve threatens to do the same to him. In the end Patrick penetrates Lisa with the bowling pin as she screams in pain. The four leave Lisa on the pool table, naked and barely conscious.
The following night, the two groups arrive at the bowling alley to continue their tournament. Steve is joined by his "girlfriends", Julia and Hannah. Jamie arrives late with Lisa, who barely speaks. As the teams begin their first game of the night, Lisa suddenly gets on an elevator. She is confronted by Patrick, who says he's only at the bowling alley to apologize. Lisa doesn't believe him, and insists that he is only there to make sure that she hasn't contacted the police. During the game, the players notice a mystery player on the scoreboard, BBK, but believe it is just a glitch. Dave, one of Jamie's friends, meets Julia in the bar and pays for two beers she ordered. When he discovers that one of them belongs to Steve, he asks if he can urinate in it. Julia tells him that she doesn't care and that she dislikes Steve too but hangs out with him anyway because he's dating her friend Hannah. Julia follows Dave into the bathroom and the two begin to make out. A mysterious person wearing bowling attire exits one of the stalls while Dave and Julia are in the 69 position and forces Julia's head further onto Dave's penis while forcing Dave's head further between Julia's legs, suffocating them both. After they are dead, two strikes appear next to BBK on the scoreboard in the form of a skull and crossbones.
The game continues and Sam goes to the bathroom so she can "freshen up". The person who murdered Dave and Julia is hiding in one of the stalls when Sam enters the girls' restroom and Sam, frightened by the noise coming from the stall, approaches it and is pulled inside. She tries to bargain with the killer, but the killer murders her by forcing a bowling pin down her throat. The killer lifts Sam's skirt up and, using the switchblade Sam tried to defend herself with, castrates Sam lengthwise. Later, Ben and Cindy leave to have sex in a storage room upstairs, but Ben leaves Cindy alone to buy a condom from the vending machine in the bathroom. He dies when the killer hits him over the head with a bowling pin and gouges his eyes out with a sharpened one. The killer finds Cindy upstairs and strangles her to death with a pair of bowling sneakers. Downstairs, Hannah searches for Julia but dies when the killer crushes her head with two bowling balls. Joey goes back behind the pin setters to fix his team's after noticing they were broken. A.J. notices the strikes appearing next to BBK on the scoreboard and questions Egerton about it, who assures him that it is still a glitch. Egerton sends A.J. to an area currently being remodeled with an "out of order" sign to put on an automatic ball polisher that Joey broke earlier. A.J. turns the ball polisher on and finds it already fixed but gets killed when the killer uses it to wax his face off.
Steve, noticing that something is amiss, leaves to find Joey behind the pin setters. Joey lies dead on the ground, headless. Steve is frightened by the killer, who bludgeons him with a bowling pin before sodomizing him with another sharpened pin. As Steve tries to crawl away, the killer smashes his head in with the bowling pin. Meanwhile, Sarah and Jamie continue their game. Jamie reaches into the ball return slot to find his bowling ball, instead discovering Joey's severed head. The two try desperately to escape the bowling alley before coming face to face with the killer. They run and hide in the basement, where they find their friends' bodies. The killer appears with a shotgun and removes the bowling bag to reveal Egerton's face. Sarah discovers that Jamie knew about the murders of Steve, Joey, and A.J. but not the others. Lisa appears, dressed up as well, revealing that she murdered Steve. Jamie explains that Lisa told her father, who turns out to be Egerton, about the rape and Egerton let Jamie in on the plan. When asked why he killed their friends too, Egerton explains that they didn't intervene when Lisa reentered the bowling alley and are therefore just as guilty. Another person dressed like the killer, as Egerton goes on to explain, Another killer (possibly the real "BBK") enters the basement and removes the bowling bag to reveal Patrick's face. Patrick explains that he confessed his involvement to Egerton and wanted to contact the police, but Egerton let him in on the plan instead and he was the person who murdered Joey and A.J., supposedly to make it up to her. Lisa is furious that her father allowed him to live so Egerton betrays Patrick and slits his throat with the switchblade he got from Sam. Jamie, realizing he's out of control, wrestles Egerton to the ground and, after a scuffle, blows his head clean off with the shotgun. Lisa cradles her father's body before grabbing the switchblade and trying to attack Jamie. Sarah grabs the shotgun and kills Lisa.
With the three "BBK"'s dead, Sarah shoots the locks off of the emergency doors and the two survivors escape the bowling alley. Traumatized and, above all, upset that Jamie did nothing to prevent the murders, Sarah turns the gun on him, pumps it saying: "'cuz we're both fucked". The screen cuts to black as a gunshot is heard, indicating that Sarah murdered Jamie and is on the run.
                            [title] => Gutterballs
                            [question_id] => 5626112d-03d0-bd33-377e-e672b8d4b8b6
                            [question] => How is Sam killed?
                            [answers] => Array
                                (
                                    [0] => Bowling pin down her throat
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [42] => Array
                (
                    [row_idx] => 42
                    [row] => Array
                        (
                            [plot_id] => /m/03mdpqr
                            [plot] => This article's plot summary may be too long or excessively detailed. Please help improve it by removing unnecessary details and making it more concise. (September 2015) (Learn how and when to remove this template message)
On January 1, 2008 at the Xcalibur Bowling Centre, a disco-themed bowling alley in Surrey, British Columbia, Egerton, the janitor, has allowed two groups of teenagers to bowl against one another after hours. The "prep", Steve, is still bitter after his best friend Jamie, the "jock", had sex with Lisa, a girl with whom Steve was smitten and even took to their senior prom. After Steve and his friends Joey, Patrick, and A.J. harass the "tranny", Sam, they are chastised by Jamie. This leads to a brawl between Steve's team and Jamie's. Lisa breaks up the fight by dropping a bowling ball on Steve's foot just as Steve is about to kick Jamie again. Egerton, brandishing a shotgun, tells the teenagers to leave and they can continue their tournament the following night.
Lisa, having forgot her purse in the arcade, returns to find Steve and his friends waiting for her. Steve proceeds to violently rape Lisa while the others watch. Egerton is oblivious to Lisa's cries for help, as he is downstairs cleaning up the mess the teenagers made. After he is finished raping Lisa, Steve leaves the room. While Steve is gone, A.J. anally rapes Lisa on the pool table; then it's Joey who abuses her. Patrick, who believed the three were only going to "scare" Lisa, refuses to participate in the rape. Steve returns with a bowling pin and prepares to insert it into Lisa before Patrick intervenes. Steve retorts by giving Patrick the pin and ordering him to do it himself. Patrick refuses to do so at first but complies when Steve threatens to do the same to him. In the end Patrick penetrates Lisa with the bowling pin as she screams in pain. The four leave Lisa on the pool table, naked and barely conscious.
The following night, the two groups arrive at the bowling alley to continue their tournament. Steve is joined by his "girlfriends", Julia and Hannah. Jamie arrives late with Lisa, who barely speaks. As the teams begin their first game of the night, Lisa suddenly gets on an elevator. She is confronted by Patrick, who says he's only at the bowling alley to apologize. Lisa doesn't believe him, and insists that he is only there to make sure that she hasn't contacted the police. During the game, the players notice a mystery player on the scoreboard, BBK, but believe it is just a glitch. Dave, one of Jamie's friends, meets Julia in the bar and pays for two beers she ordered. When he discovers that one of them belongs to Steve, he asks if he can urinate in it. Julia tells him that she doesn't care and that she dislikes Steve too but hangs out with him anyway because he's dating her friend Hannah. Julia follows Dave into the bathroom and the two begin to make out. A mysterious person wearing bowling attire exits one of the stalls while Dave and Julia are in the 69 position and forces Julia's head further onto Dave's penis while forcing Dave's head further between Julia's legs, suffocating them both. After they are dead, two strikes appear next to BBK on the scoreboard in the form of a skull and crossbones.
The game continues and Sam goes to the bathroom so she can "freshen up". The person who murdered Dave and Julia is hiding in one of the stalls when Sam enters the girls' restroom and Sam, frightened by the noise coming from the stall, approaches it and is pulled inside. She tries to bargain with the killer, but the killer murders her by forcing a bowling pin down her throat. The killer lifts Sam's skirt up and, using the switchblade Sam tried to defend herself with, castrates Sam lengthwise. Later, Ben and Cindy leave to have sex in a storage room upstairs, but Ben leaves Cindy alone to buy a condom from the vending machine in the bathroom. He dies when the killer hits him over the head with a bowling pin and gouges his eyes out with a sharpened one. The killer finds Cindy upstairs and strangles her to death with a pair of bowling sneakers. Downstairs, Hannah searches for Julia but dies when the killer crushes her head with two bowling balls. Joey goes back behind the pin setters to fix his team's after noticing they were broken. A.J. notices the strikes appearing next to BBK on the scoreboard and questions Egerton about it, who assures him that it is still a glitch. Egerton sends A.J. to an area currently being remodeled with an "out of order" sign to put on an automatic ball polisher that Joey broke earlier. A.J. turns the ball polisher on and finds it already fixed but gets killed when the killer uses it to wax his face off.
Steve, noticing that something is amiss, leaves to find Joey behind the pin setters. Joey lies dead on the ground, headless. Steve is frightened by the killer, who bludgeons him with a bowling pin before sodomizing him with another sharpened pin. As Steve tries to crawl away, the killer smashes his head in with the bowling pin. Meanwhile, Sarah and Jamie continue their game. Jamie reaches into the ball return slot to find his bowling ball, instead discovering Joey's severed head. The two try desperately to escape the bowling alley before coming face to face with the killer. They run and hide in the basement, where they find their friends' bodies. The killer appears with a shotgun and removes the bowling bag to reveal Egerton's face. Sarah discovers that Jamie knew about the murders of Steve, Joey, and A.J. but not the others. Lisa appears, dressed up as well, revealing that she murdered Steve. Jamie explains that Lisa told her father, who turns out to be Egerton, about the rape and Egerton let Jamie in on the plan. When asked why he killed their friends too, Egerton explains that they didn't intervene when Lisa reentered the bowling alley and are therefore just as guilty. Another person dressed like the killer, as Egerton goes on to explain, Another killer (possibly the real "BBK") enters the basement and removes the bowling bag to reveal Patrick's face. Patrick explains that he confessed his involvement to Egerton and wanted to contact the police, but Egerton let him in on the plan instead and he was the person who murdered Joey and A.J., supposedly to make it up to her. Lisa is furious that her father allowed him to live so Egerton betrays Patrick and slits his throat with the switchblade he got from Sam. Jamie, realizing he's out of control, wrestles Egerton to the ground and, after a scuffle, blows his head clean off with the shotgun. Lisa cradles her father's body before grabbing the switchblade and trying to attack Jamie. Sarah grabs the shotgun and kills Lisa.
With the three "BBK"'s dead, Sarah shoots the locks off of the emergency doors and the two survivors escape the bowling alley. Traumatized and, above all, upset that Jamie did nothing to prevent the murders, Sarah turns the gun on him, pumps it saying: "'cuz we're both fucked". The screen cuts to black as a gunshot is heard, indicating that Sarah murdered Jamie and is on the run.
                            [title] => Gutterballs
                            [question_id] => b64c9861-4bb7-96f0-6889-4b486927b589
                            [question] => Who dies while searching for Julia?
                            [answers] => Array
                                (
                                    [0] => Hannah
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

            [43] => Array
                (
                    [row_idx] => 43
                    [row] => Array
                        (
                            [plot_id] => /m/03mdpqr
                            [plot] => This article's plot summary may be too long or excessively detailed. Please help improve it by removing unnecessary details and making it more concise. (September 2015) (Learn how and when to remove this template message)
On January 1, 2008 at the Xcalibur Bowling Centre, a disco-themed bowling alley in Surrey, British Columbia, Egerton, the janitor, has allowed two groups of teenagers to bowl against one another after hours. The "prep", Steve, is still bitter after his best friend Jamie, the "jock", had sex with Lisa, a girl with whom Steve was smitten and even took to their senior prom. After Steve and his friends Joey, Patrick, and A.J. harass the "tranny", Sam, they are chastised by Jamie. This leads to a brawl between Steve's team and Jamie's. Lisa breaks up the fight by dropping a bowling ball on Steve's foot just as Steve is about to kick Jamie again. Egerton, brandishing a shotgun, tells the teenagers to leave and they can continue their tournament the following night.
Lisa, having forgot her purse in the arcade, returns to find Steve and his friends waiting for her. Steve proceeds to violently rape Lisa while the others watch. Egerton is oblivious to Lisa's cries for help, as he is downstairs cleaning up the mess the teenagers made. After he is finished raping Lisa, Steve leaves the room. While Steve is gone, A.J. anally rapes Lisa on the pool table; then it's Joey who abuses her. Patrick, who believed the three were only going to "scare" Lisa, refuses to participate in the rape. Steve returns with a bowling pin and prepares to insert it into Lisa before Patrick intervenes. Steve retorts by giving Patrick the pin and ordering him to do it himself. Patrick refuses to do so at first but complies when Steve threatens to do the same to him. In the end Patrick penetrates Lisa with the bowling pin as she screams in pain. The four leave Lisa on the pool table, naked and barely conscious.
The following night, the two groups arrive at the bowling alley to continue their tournament. Steve is joined by his "girlfriends", Julia and Hannah. Jamie arrives late with Lisa, who barely speaks. As the teams begin their first game of the night, Lisa suddenly gets on an elevator. She is confronted by Patrick, who says he's only at the bowling alley to apologize. Lisa doesn't believe him, and insists that he is only there to make sure that she hasn't contacted the police. During the game, the players notice a mystery player on the scoreboard, BBK, but believe it is just a glitch. Dave, one of Jamie's friends, meets Julia in the bar and pays for two beers she ordered. When he discovers that one of them belongs to Steve, he asks if he can urinate in it. Julia tells him that she doesn't care and that she dislikes Steve too but hangs out with him anyway because he's dating her friend Hannah. Julia follows Dave into the bathroom and the two begin to make out. A mysterious person wearing bowling attire exits one of the stalls while Dave and Julia are in the 69 position and forces Julia's head further onto Dave's penis while forcing Dave's head further between Julia's legs, suffocating them both. After they are dead, two strikes appear next to BBK on the scoreboard in the form of a skull and crossbones.
The game continues and Sam goes to the bathroom so she can "freshen up". The person who murdered Dave and Julia is hiding in one of the stalls when Sam enters the girls' restroom and Sam, frightened by the noise coming from the stall, approaches it and is pulled inside. She tries to bargain with the killer, but the killer murders her by forcing a bowling pin down her throat. The killer lifts Sam's skirt up and, using the switchblade Sam tried to defend herself with, castrates Sam lengthwise. Later, Ben and Cindy leave to have sex in a storage room upstairs, but Ben leaves Cindy alone to buy a condom from the vending machine in the bathroom. He dies when the killer hits him over the head with a bowling pin and gouges his eyes out with a sharpened one. The killer finds Cindy upstairs and strangles her to death with a pair of bowling sneakers. Downstairs, Hannah searches for Julia but dies when the killer crushes her head with two bowling balls. Joey goes back behind the pin setters to fix his team's after noticing they were broken. A.J. notices the strikes appearing next to BBK on the scoreboard and questions Egerton about it, who assures him that it is still a glitch. Egerton sends A.J. to an area currently being remodeled with an "out of order" sign to put on an automatic ball polisher that Joey broke earlier. A.J. turns the ball polisher on and finds it already fixed but gets killed when the killer uses it to wax his face off.
Steve, noticing that something is amiss, leaves to find Joey behind the pin setters. Joey lies dead on the ground, headless. Steve is frightened by the killer, who bludgeons him with a bowling pin before sodomizing him with another sharpened pin. As Steve tries to crawl away, the killer smashes his head in with the bowling pin. Meanwhile, Sarah and Jamie continue their game. Jamie reaches into the ball return slot to find his bowling ball, instead discovering Joey's severed head. The two try desperately to escape the bowling alley before coming face to face with the killer. They run and hide in the basement, where they find their friends' bodies. The killer appears with a shotgun and removes the bowling bag to reveal Egerton's face. Sarah discovers that Jamie knew about the murders of Steve, Joey, and A.J. but not the others. Lisa appears, dressed up as well, revealing that she murdered Steve. Jamie explains that Lisa told her father, who turns out to be Egerton, about the rape and Egerton let Jamie in on the plan. When asked why he killed their friends too, Egerton explains that they didn't intervene when Lisa reentered the bowling alley and are therefore just as guilty. Another person dressed like the killer, as Egerton goes on to explain, Another killer (possibly the real "BBK") enters the basement and removes the bowling bag to reveal Patrick's face. Patrick explains that he confessed his involvement to Egerton and wanted to contact the police, but Egerton let him in on the plan instead and he was the person who murdered Joey and A.J., supposedly to make it up to her. Lisa is furious that her father allowed him to live so Egerton betrays Patrick and slits his throat with the switchblade he got from Sam. Jamie, realizing he's out of control, wrestles Egerton to the ground and, after a scuffle, blows his head clean off with the shotgun. Lisa cradles her father's body before grabbing the switchblade and trying to attack Jamie. Sarah grabs the shotgun and kills Lisa.
With the three "BBK"'s dead, Sarah shoots the locks off of the emergency doors and the two survivors escape the bowling alley. Traumatized and, above all, upset that Jamie did nothing to prevent the murders, Sarah turns the gun on him, pumps it saying: "'cuz we're both fucked". The screen cuts to black as a gunshot is heard, indicating that Sarah murdered Jamie and is on the run.
                            [title] => Gutterballs
                            [question_id] => e3ffd095-9e40-43d7-bb79-3515dac7cd1f
                            [question] => What is the name of the disco-themed bowling alley?
                            [answers] => Array
                                (
                                    [0] => Xcalibur Bowling Centre
                                )

                            [no_answer] =>
                        )

                    [truncated_cells] => Array
                        (
                        )

                )

        )

    [truncated] => 1
)
```