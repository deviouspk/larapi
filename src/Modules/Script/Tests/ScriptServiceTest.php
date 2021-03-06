<?php

namespace Modules\Script\Tests;

use Foundation\Abstracts\Tests\TestCase;
use Modules\Script\Contracts\ScriptServiceContract;
use Modules\Script\Dtos\CreateScriptDto;
use Modules\Script\Dtos\GrantUserExclusivityDto;
use Modules\Script\Dtos\UpdateUserExclusivityDto;
use Modules\Script\Entities\Script;
use Modules\Script\Entities\ScriptExclusivity;
use Modules\Script\Entities\ScriptRelease;
use Modules\Script\Entities\ScriptReview;
use Modules\Script\Entities\ScriptReviewReply;
use Modules\Script\Events\ScriptWasReviewedEvent;
use Modules\Script\Exceptions\ScriptAlreadyReviewedException;
use Modules\Script\Exceptions\ScriptReviewReplyAlreadyExistsException;
use Modules\Script\Services\ScriptService;

class ScriptServiceTest extends TestCase
{
    /**
     * @var Script
     */
    protected $script;

    /**
     * @var ScriptService
     */
    protected $service;


    protected function seedData()
    {
        $this->service = $this->app->make(ScriptServiceContract::class);
        $this->script = $this->service->create(new CreateScriptDto(Script::fromFactory()->raw()));
    }

    /**
     * Tests creating the initial release and publishing a new one.
     *
     * @return void
     */
    public function testPublishScriptRelease()
    {
        $script = $this->service->releaseVersion($this->script, ScriptRelease::fromFactory()->raw());

        $this->assertCount(2, $script->releases);
    }

    /**
     * Tests creating a script review.
     *
     * @return void
     */
    public function testCreateScriptReview()
    {
        $review = $this->service->publishReview($this->script, ScriptReview::fromFactory()->raw());
        $this->assertCount(1, $this->script->reviews);
        $this->assertEquals($review->version, $this->script->releases->last()->version);

        $this->expectExceptionObject(new ScriptAlreadyReviewedException());
        $this->service->publishReview($this->script, ScriptReview::fromFactory()->raw());
        event(new ScriptWasReviewedEvent($review));
    }

    /**
     * Tests creating a script review reply.
     *
     * @return void
     */
    public function testCreateScriptReviewReply()
    {
        $review = $this->service->publishReview($this->script, ScriptReview::fromFactory()->raw());
        $this->assertCount(1, $this->script->reviews);

        $reply = $this->service->publishReviewReply($this->script, ScriptReviewReply::fromFactory()->raw(["review_id" => $review->id]));
        $this->assertNotNull($reply);

        $this->expectExceptionObject(new ScriptReviewReplyAlreadyExistsException());
        $this->service->publishReviewReply($this->script, ScriptReviewReply::fromFactory()->raw(["review_id" => $review->id]));
    }

    /**
     * Tests granting script exclusivity.
     *
     * @return void
     */
    public function testGrantScriptExclusivity()
    {
        $data = new GrantUserExclusivityDto(ScriptExclusivity::fromFactory()->raw(["user_id" => $this->getActingUser()->id]));

        $exclusivity = $this->service->grantUserExclusivity($this->script, $data);
        $this->assertNotNull($exclusivity);
        $this->assertArrayHasKey(ScriptExclusivity::USER_ID, $exclusivity);
        $this->assertArrayHasKey(ScriptExclusivity::RECURRING_PRICE, $exclusivity);
        $this->assertArrayHasKey(ScriptExclusivity::BASE_PRICE, $exclusivity);
        $this->assertCount(1, $this->script->exclusivity);
    }

    /**
     * Tests granting script exclusivity.
     *
     * @return void
     */
    public function testRemoveScriptExclusivity()
    {
        $data = new GrantUserExclusivityDto(ScriptExclusivity::fromFactory()->raw(["user_id" => $this->getActingUser()->id]));

        $this->service->grantUserExclusivity($this->script, $data);
        $this->assertCount(1, $this->script->exclusivity);
        $this->service->removeUserExclusivity($this->script, $this->getActingUser()->id);
        $this->assertCount(0, $this->script->exclusivity);
    }

    /**
     * Tests granting script exclusivity.
     *
     * @return void
     */
    public function testUpdateScriptExclusivity()
    {
        $data = new GrantUserExclusivityDto(ScriptExclusivity::fromFactory()->raw(["user_id" => $this->getActingUser()->id]));
        $this->service->grantUserExclusivity($this->script, $data);
        $this->assertCount(1, $this->script->exclusivity);

        $data = new UpdateUserExclusivityDto(ScriptExclusivity::fromFactory()->raw(["user_id" => $this->getActingUser()->id]));
        $exclusivity = $this->service->updateUserExclusivity($this->script, $data);
        $this->assertEquals($data->user_id, $exclusivity->user_id);
        $this->assertEquals($data->base_price, $exclusivity->base_price);
        $this->assertEquals($data->recurring_price, $exclusivity->recurring_price);
    }
}
